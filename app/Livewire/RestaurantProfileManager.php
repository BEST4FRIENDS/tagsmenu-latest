<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use App\Models\PortalCategory;
use App\Services\HashtagService;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
// NEU: Imports für Collection und Storage
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class RestaurantProfileManager extends Component
{
    use WithFileUploads;

    // NEU: Nullable Type, da das Restaurant evtl. noch nicht existiert
    public ?Restaurant $restaurant = null;

    // Felder für das Formular (Initialisierung hinzugefügt)
    public $about_us = '';
    // public $address; // ENTFERNT: Wird im Hauptformular (Teil 1) verwaltet
    public $is_publicly_listed = true;
    public $cover_image; // Für den Upload

    // Felder für Kategorien und Hashtags (Typing hinzugefügt)
    public Collection $allCategories;
    public $selectedCategories = [];
    public $hashtagsInput = '';

    // Regeln aktualisiert (address entfernt)
    protected $rules = [
        'about_us' => 'nullable|string|max:1000',
        'is_publicly_listed' => 'required|boolean',
        'selectedCategories' => 'nullable|array',
        'hashtagsInput' => 'nullable|string|max:500',
        'cover_image' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function mount()
    {
        $this->restaurant = Auth::user()->restaurant;

        // Robustheit: Sicherstellen, dass das Restaurant existiert
        if (!$this->restaurant) {
            $this->allCategories = collect(); // Leere Collection initialisieren und abbrechen
            return;
        }

        // Daten aus dem Restaurant-Model laden (mit Null-Coalescing Operator ??)
        $this->about_us = $this->restaurant->about_us ?? '';
        $this->is_publicly_listed = $this->restaurant->is_publicly_listed ?? true;

        // Kategorien laden
        $this->allCategories = PortalCategory::all();
        $this->selectedCategories = $this->restaurant->portalCategories()->pluck('id')->toArray();

        // Hashtags laden
        $this->hashtagsInput = $this->restaurant->hashtags()->pluck('name')->implode(', ');
    }

    // Wir injizieren den HashtagService direkt in die save-Methode.
    public function save(HashtagService $hashtagService)
    {
        // Robustheit: Prüfen, ob das Restaurant existiert
        if (!$this->restaurant) return;

        $this->validate();

        // 1. Basisdaten aktualisieren
        $this->restaurant->update([
            'about_us' => $this->about_us,
            'is_publicly_listed' => $this->is_publicly_listed,
        ]);

        // 2. Cover Bild verarbeiten (falls hochgeladen)
        if ($this->cover_image) {
            // NEU: Altes Bild löschen, falls vorhanden
            if ($this->restaurant->cover_image_path && Storage::disk('public')->exists($this->restaurant->cover_image_path)) {
                Storage::disk('public')->delete($this->restaurant->cover_image_path);
            }

            // Neues Bild speichern
            $path = $this->cover_image->store('restaurant-covers', 'public');
            $this->restaurant->update(['cover_image_path' => $path]);
            $this->cover_image = null; // Reset des Upload-Feldes
        }

        // 3. Kategorien synchronisieren
        $this->restaurant->portalCategories()->sync($this->selectedCategories);

        // 4. Hashtags verarbeiten und synchronisieren
        $hashtagIds = $hashtagService->processHashtags($this->hashtagsInput);
        $this->restaurant->hashtags()->sync($hashtagIds);

        // 5. Meilisearch Index aktualisieren
        if ($this->restaurant->shouldBeSearchable()) {
            $this->restaurant->searchable();
        } else {
            $this->restaurant->unsearchable();
        }

        // Refresh des Models, um sicherzustellen, dass die View aktuelle Daten hat (z.B. neuer Bildpfad).
        $this->restaurant->refresh();

        session()->flash('message', 'Portal-Profil erfolgreich aktualisiert.');
    }

    public function render()
    {
        return view('livewire.restaurant-profile-manager');
    }
}