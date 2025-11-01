<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuImport implements ToCollection, WithHeadingRow
{
    protected Restaurant $restaurant;
    protected array $categoryCache = [];
    protected array $locales = ['de', 'en', 'hu', 'sk']; // Definieren Sie Ihre Sprachen hier

    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
        // Das Cache wird jetzt nur mit der Hauptsprache (de) initialisiert, um Gerichte zu finden
        $this->initializeCategoryCache('de');
    }

    private function prepareRowData(array $data): array
    {
        if (isset($data['preis'])) {
            $price = preg_replace('/[^\d,\.]/', '', (string)$data['preis']);
            if (strpos($price, ',') !== false) {
                $price = str_replace('.', '', $price);
                $price = str_replace(',', '.', $price);
            }
            $data['preis'] = $price;
        }
        if (isset($data['typ_fooddrink'])) {
            $data['typ_fooddrink'] = strtolower(trim($data['typ_fooddrink']));
        }
        return $data;
    }

    private function getValidationRules(): array
    {
        $rules = [
            'typ_fooddrink' => ['required', Rule::in(['food', 'drink'])],
            'preis' => 'required|numeric|min:0',
        ];

        // Fügt Regeln für jede Sprache hinzu
        foreach ($this->locales as $locale) {
            // Mindestens die Hauptsprache (de) muss für Kategorie und Name ausgefüllt sein
            $required = ($locale === 'de') ? 'required' : 'nullable';

            $rules['kategorie_' . $locale] = $required . '|string|max:255|distinct';
            $rules['gericht_name_' . $locale] = $required . '|string|max:255|distinct';
            $rules['gericht_beschreibung_' . $locale] = 'nullable|string';
        }
        return $rules;
    }
    
    private function getValidationMessages(): array
    {
        return [
            'typ_fooddrink.in' => 'Der Wert in der Spalte "typ_fooddrink" muss entweder "food" oder "drink" sein.',
            'preis.numeric' => 'Der Preis muss eine gültige Zahl sein.',
            'kategorie_de.required' => 'Die Spalte "kategorie_de" ist ein Pflichtfeld.',
            'gericht_name_de.required' => 'Die Spalte "gericht_name_de" ist ein Pflichtfeld.',
        ];
    }

    public function collection(Collection $rows)
    {
        $validatedRows = [];
        // 1. Alle Zeilen validieren, bevor wir etwas in die DB schreiben
        foreach ($rows as $row) {
            $preparedData = $this->prepareRowData($row->toArray());
            $validator = Validator::make($preparedData, $this->getValidationRules(), $this->getValidationMessages());
            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }
            $validatedRows[] = $validator->validated();
        }

        // 2. Transaktion starten und validierte Daten verarbeiten
        DB::beginTransaction();
        try {
            foreach ($validatedRows as $row) {
                // Hauptdaten extrahieren
                $type = $row['typ_fooddrink'];
                $price = $row['preis'];
                
                // Wir verwenden die deutsche Kategorie/Name als Basis, um das Objekt zu finden oder zu erstellen
                $primaryCategoryName = trim($row['kategorie_de']);
                $primaryDishName = trim($row['gericht_name_de']);

                $categoryId = $this->getOrCreateCategory($primaryCategoryName, $type);
                $dish = $this->findDishByTranslation($primaryDishName, $categoryId);

                // Gericht erstellen oder aktualisieren
                if ($dish) {
                    $dish->update(['price' => $price, 'is_available' => true]);
                } else {
                    $dish = Dish::create([
                        'category_id' => $categoryId,
                        'price' => $price,
                        'is_available' => true,
                    ]);
                }

                // Durch alle Sprachen loopen und die Übersetzungen speichern
                foreach ($this->locales as $locale) {
                    $categoryName = trim($row['kategorie_' . $locale] ?? '');
                    $dishName = trim($row['gericht_name_' . $locale] ?? '');
                    $description = trim($row['gericht_beschreibung_' . $locale] ?? '');

                    // Nur speichern, wenn ein Name für diese Sprache vorhanden ist
                    if (!empty($dishName)) {
                        $dish->translations()->updateOrCreate(
                            ['locale' => $locale],
                            ['name' => $dishName, 'description' => $description]
                        );
                    }
                    // Übersetzungen für die Kategorie speichern (wichtig für neue Kategorien)
                    if (!empty($categoryName)) {
                        $dish->category->translations()->updateOrCreate(
                            ['locale' => $locale],
                            ['name' => $categoryName]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Menu import transaction failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    private function initializeCategoryCache(string $locale): void
    {
        $categories = $this->restaurant->categories()->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();
        foreach ($categories as $category) {
            $translation = $category->translations->first();
            if ($translation) {
                $key = $this->getCategoryCacheKey($category->type, $translation->name);
                $this->categoryCache[$key] = $category->id;
            }
        }
    }

    private function getCategoryCacheKey(string $type, string $name): string
    {
        return $type . '_' . strtolower(trim($name));
    }

    private function getOrCreateCategory(string $name, string $type): int
    {
        $key = $this->getCategoryCacheKey($type, $name);
        if (isset($this->categoryCache[$key])) {
            return $this->categoryCache[$key];
        }
        $category = Category::create([
            'restaurant_id' => $this->restaurant->id,
            'type' => $type,
            'position' => (Category::where('restaurant_id', $this->restaurant->id)->where('type', $type)->max('position') ?? 0) + 1,
        ]);
        // Hauptübersetzung (de) wird sofort gespeichert
        $category->translations()->create(['locale' => 'de', 'name' => $name]);
        $this->categoryCache[$key] = $category->id;
        return $category->id;
    }

    private function findDishByTranslation(string $name, int $categoryId): ?Dish
    {
        return Dish::where('category_id', $categoryId)
            ->whereHas('translations', function ($query) use ($name) {
                $query->where('locale', 'de')->where('name', $name);
            })
            ->first();
    }
}