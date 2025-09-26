<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // HILFSFUNKTION, UM WIEDERHOLUNG ZU VERMEIDEN
    private function checkRestaurant()
    {
        $restaurant = Auth::user()->restaurant;
        if (! $restaurant) {
            // Leitet den Benutzer zu den Einstellungen, um ein Restaurant zu erstellen/zuzuweisen.
            // Wir fügen eine Fehlermeldung hinzu, um zu erklären, warum.
            return redirect()->route('settings.index')->with('error', 'Sie müssen zuerst ein Restaurant in den Einstellungen anlegen oder sich einem zuweisen.');
        }
        return $restaurant;
    }

    public function index()
    {
        if (($redirect = $this->checkRestaurant()) instanceof \Illuminate\Http\RedirectResponse) {
            return $redirect;
        }
        $restaurant = $this->checkRestaurant();
        
        $categories = $restaurant->categories()->with('translations')->get();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_de' => 'required|string|max:255',
            // ... (andere Sprachvalidierungen)
        ]);

        if (($redirect = $this->checkRestaurant()) instanceof \Illuminate\Http\RedirectResponse) {
            return $redirect;
        }
        $restaurant = $this->checkRestaurant();

        $category = $restaurant->categories()->create([]);
        $this->updateTranslations($category, $validated);

        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich erstellt!');
    }

    public function edit(Category $category)
    {
        if ($category->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        if ($category->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name_de' => 'required|string|max:255',
             // ... (andere Sprachvalidierungen)
        ]);

        $this->updateTranslations($category, $validated);

        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich aktualisiert!');
    }

    public function destroy(Category $category)
    {
        if ($category->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich gelöscht!');
    }

    private function updateTranslations(Category $category, array $data)
    {
        $translations = [
            'de' => ['name' => $data['name_de']],
            'en' => ['name' => $data['name_en'] ?? null],
            'hu' => ['name' => $data['name_hu'] ?? null],
            'sk' => ['name' => $data['name_sk'] ?? null],
        ];

        foreach ($translations as $locale => $transData) {
            if (!empty($transData['name'])) {
                $category->translations()->updateOrCreate(
                    ['locale' => $locale],
                    ['name' => $transData['name']]
                );
            }
        }
    }
}