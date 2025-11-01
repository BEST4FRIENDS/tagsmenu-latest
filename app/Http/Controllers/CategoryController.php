<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    private function getRestaurantOrFail(): Restaurant|RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            return redirect()->route('settings.index')->with('error', 'Sie müssen zuerst ein Restaurant anlegen.');
        }
        return $restaurant;
    }

    public function index(Request $request): View|RedirectResponse
    {
        $restaurant = $this->getRestaurantOrFail();
        if ($restaurant instanceof RedirectResponse) return $restaurant;

        $type = $request->query('type', 'food');

        $categories = $restaurant->categories()
            ->where('type', $type)
            ->with('translations')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
            'type' => $type
        ]);
    }

    public function create(Request $request): View
    {
        $type = $request->query('type', 'food');
        return view('categories.create', ['type' => $type]);
    }

    public function store(Request $request): RedirectResponse
    {
        $restaurant = $this->getRestaurantOrFail();
        if ($restaurant instanceof RedirectResponse) return $restaurant;

        $validated = $request->validate([
            'name_de' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_hu' => 'nullable|string|max:255',
            'name_sk' => 'nullable|string|max:255',
            'type'    => 'required|in:food,drink',
        ]);

        $category = $restaurant->categories()->create([
            'type' => $validated['type'],
        ]);

        $this->updateTranslations($category, $validated);

        return redirect()->route('categories.index', ['type' => $category->type])->with('success', 'Kategorie erfolgreich erstellt!');
    }

    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);
        
        $validated = $request->validate([
            'name_de' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_hu' => 'nullable|string|max:255',
            'name_sk' => 'nullable|string|max:255',
            'type'    => 'required|in:food,drink',
        ]);

        $category->update([
            'type' => $validated['type'],
        ]);

        $this->updateTranslations($category, $validated);

        return redirect()->route('categories.index', ['type' => $category->type])->with('success', 'Kategorie erfolgreich aktualisiert!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        $type = $category->type;
        $category->delete();
        
        return redirect()->route('categories.index', ['type' => $type])->with('success', 'Kategorie erfolgreich gelöscht!');
    }

    private function updateTranslations(Category $category, array $data): void
    {
        $translations = [
            'de' => ['name' => $data['name_de'] ?? null],
            'en' => ['name' => $data['name_en'] ?? null],
            'hu' => ['name' => $data['name_hu'] ?? null],
            'sk' => ['name' => $data['name_sk'] ?? null],
        ];

        foreach ($translations as $locale => $transData) {
            if (!empty($transData['name'])) {
                $category->translations()->updateOrCreate(
                    ['locale' => $locale],
                    $transData
                );
            }
        }
    }
}