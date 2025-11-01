<?php

namespace App\Livewire;

use App\Models\Dish;
use App\Services\HashtagService; // NEU
use Livewire\Component;

class DishForm extends Component
{
    public Dish $dish;
    // ... (andere Eigenschaften wie Name, Preis etc.)

    // NEU: Eigenschaft für Hashtags
    public $hashtagsInput = '';

    public function mount(Dish $dish = null)
    {
        if ($dish && $dish->exists) {
            $this->dish = $dish;
            // ... (andere Felder laden)

            // NEU: Hashtags laden und formatieren
            $this->hashtagsInput = $this->dish->hashtags()->pluck('name')->implode(', ');
        } else {
            $this->dish = new Dish();
        }
    }

    // NEU: Injizieren des HashtagService
    public function save(HashtagService $hashtagService)
    {
        // ... Validierung und Speicherung der Gerichte-Basisdaten ...
        // $this->dish->save();

        // NEU: Hashtags verarbeiten und synchronisieren
        $hashtagIds = $hashtagService->processHashtags($this->hashtagsInput);
        $this->dish->hashtags()->sync($hashtagIds);

        // Feedback und Weiterleitung
        session()->flash('message', 'Gericht erfolgreich gespeichert.');
        // return redirect()->route('dashboard.dishes.index');
    }

    public function render()
    {
        return view('livewire.dish-form');
    }
}