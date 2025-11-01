<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDishRequest;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// NEUER IMPORT für den HashtagService
use App\Services\HashtagService;

class DishController extends Controller
{
    use AuthorizesRequests;

    // NEU: Property für den injizierten Service
    protected $hashtagService;

    // NEU: Injizieren des HashtagService über den Konstruktor
    public function __construct(HashtagService $hashtagService)
    {
        $this->hashtagService = $hashtagService;
    }

    private function getRestaurantOrFail(): Restaurant|RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            return redirect()->route('settings.index')->with('error', 'Sie müssen zuerst ein Restaurant anlegen.');
        }
        return $restaurant;
    }

    /**
     * KORREKTUR: Index-Methode vereinfacht. Daten werden von Livewire geladen.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $restaurant = $this->getRestaurantOrFail();
        if ($restaurant instanceof RedirectResponse) return $restaurant;

        // Wir benötigen hier keine Datenladung mehr.
        return view('dishes.index');
    }

    public function create(Request $request): View|RedirectResponse
    {
        $restaurant = $this->getRestaurantOrFail();
        if ($restaurant instanceof RedirectResponse) return $restaurant;

        $type = $request->query('type', 'food');
        
        // --- ERSTE KORREKTUR HIER ---
        // Die Abfrage verwendet jetzt die dynamische $type-Variable.
        $categories = $restaurant->categories()->where('type', $type)->with('translations')->get();

        return view('dishes.create', ['categories' => $categories, 'type' => $type]);
    }

    public function store(StoreDishRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('dishes', 'public');
        }

        $isFood = $validated['type'] === 'food';

        $dish = Dish::create([
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'image_url' => $imagePath,
            'is_special' => $isFood ? $request->boolean('is_special') : false,
            'is_vegetarian' => $isFood ? $request->boolean('is_vegetarian') : false,
            'is_available' => true,
        ]);

        // NEU: Hashtags verarbeiten und synchronisieren (nur für Speisen)
        if ($isFood) {
            $hashtagIds = $this->hashtagService->processHashtags($request->input('hashtags_input'));
            $dish->hashtags()->sync($hashtagIds);
        }

        $this->updateTranslations($dish, $validated);

        return redirect()->route('dishes.index', ['type' => $validated['type']])->with('success', 'Eintrag erfolgreich erstellt!');
    }
    
    public function edit(Dish $dish): View|RedirectResponse
    {
        $this->authorize('update', $dish);

        $restaurant = $this->getRestaurantOrFail();
        if ($restaurant instanceof RedirectResponse) return $restaurant;
        
        $dish->load(['translations', 'hashtags']);

        // NEU: Hashtags laden und für die View formatieren
        $currentHashtagsString = $dish->hashtags->pluck('name')->implode(', ');

        $type = $dish->category->type;

        // --- ZWEITE KORREKTUR HIER ---
        // Die Abfrage verwendet jetzt die dynamische $type-Variable.
        $categories = $restaurant->categories()->where('type', $type)->with('translations')->get();

        return view('dishes.edit', [
            'dish' => $dish, 
            'categories' => $categories, 
            'type' => $type,
            'currentHashtagsString' => $currentHashtagsString // Variable an die View übergeben
        ]);
    }

    public function update(StoreDishRequest $request, Dish $dish): RedirectResponse
    {
        $this->authorize('update', $dish);
        $validated = $request->validated();

        $imagePath = $dish->image_url;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('dishes', 'public');
        }

        $isFood = $validated['type'] === 'food';

        $dish->update([
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'image_url' => $imagePath,
            'is_special' => $isFood ? $request->boolean('is_special') : false,
            'is_vegetarian' => $isFood ? $request->boolean('is_vegetarian') : false,
        ]);

        // NEU: Hashtags verarbeiten und synchronisieren
        if ($isFood) {
            $hashtagIds = $this->hashtagService->processHashtags($request->input('hashtags_input'));
            $dish->hashtags()->sync($hashtagIds);
        } else {
            // Wenn der Typ zu 'drink' geändert wird, alle Hashtags entfernen
            $dish->hashtags()->sync([]);
        }

        $this->updateTranslations($dish, $validated);

        return redirect()->route('dishes.index', ['type' => $validated['type']])->with('success', 'Eintrag erfolgreich aktualisiert!');
    }

    public function destroy(Dish $dish): RedirectResponse
    {
        $this->authorize('delete', $dish);

        $type = $dish->category->type;

        if ($dish->image_url) {
            Storage::disk('public')->delete($dish->image_url);
        }
        $dish->delete();

        return redirect()->route('dishes.index', ['type' => $type])->with('success', 'Eintrag erfolgreich gelöscht!');
    }
    
    private function updateTranslations(Dish $dish, array $validatedData): void
    {
        $translations = [
            'de' => ['name' => $validatedData['name_de'], 'description' => $validatedData['description_de'] ?? null],
            'en' => ['name' => $validatedData['name_en'] ?? null, 'description' => $validatedData['description_en'] ?? null],
            'hu' => ['name' => $validatedData['name_hu'] ?? null, 'description' => $validatedData['description_hu'] ?? null],
            'sk' => ['name' => $validatedData['name_sk'] ?? null, 'description' => $validatedData['description_sk'] ?? null],
        ];

        foreach ($translations as $locale => $data) {
            if (!empty($data['name'])) {
                $dish->translations()->updateOrCreate(
                    ['locale' => $locale],
                    ['name' => $data['name'], 'description' => $data['description']]
                );
            }
        }
    }
}