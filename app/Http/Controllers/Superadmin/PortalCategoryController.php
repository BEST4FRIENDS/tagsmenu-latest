<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PortalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// KEIN 'Storage' Import mehr nötig

class PortalCategoryController extends Controller
{
    public function index()
    {
        $categories = PortalCategory::orderBy('name->de')->get();
        return view('superadmin.portal-categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        // Wir übergeben ein leeres Objekt für das Formular-Partial
        $portalCategory = new PortalCategory();
        return view('superadmin.portal-categories.create', compact('portalCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.*' => 'nullable|string|max:255',
            'name.de' => 'required|string|max:255',
            // KEINE 'image_path' oder 'animation_file' Validierung mehr
        ]);

        $category = new PortalCategory();
        $category->setTranslations('name', $validated['name']);
        $category->slug = Str::slug($validated['name']['de']);
        
        $category->save();

        return redirect()->route('superadmin.portal-categories.index')->with('success', 'Kategorie erfolgreich erstellt.');
    }

    public function edit(PortalCategory $portalCategory)
    {
        return view('superadmin.portal-categories.edit', ['portalCategory' => $portalCategory]);
    }

    public function update(Request $request, PortalCategory $portalCategory)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.*' => 'nullable|string|max:255',
            'name.de' => 'required|string|max:255',
        ]);
        
        $portalCategory->setTranslations('name', $validated['name']);
        $portalCategory->slug = Str::slug($validated['name']['de']);
        $portalCategory->save();

        return redirect()->route('superadmin.portal-categories.index')->with('success', 'Kategorie erfolgreich aktualisiert.');
    }

    public function destroy(PortalCategory $portalCategory)
    {
        // KEIN 'Storage::delete' mehr
        $portalCategory->delete();
        return redirect()->route('superadmin.portal-categories.index')->with('success', 'Kategorie erfolgreich gelöscht.');
    }
}