<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Wir erlauben die Anfrage grundsätzlich, die feine Berechtigungsprüfung
        // machen wir weiterhin mit der Policy im Controller.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_special' => 'nullable|boolean',
            'is_vegetarian' => 'nullable|boolean',
            'name_de' => 'required|string|max:255',
            'description_de' => 'nullable|string',
            'name_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'name_hu' => 'nullable|string|max:255',
            'description_hu' => 'nullable|string',
            'name_sk' => 'nullable|string|max:255',
            'description_sk' => 'nullable|string',
            'type' => 'required|in:food,drink',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * Diese Methode fügt nach der normalen Validierung eine zusätzliche,
     * benutzerdefinierte Prüfung hinzu.
     */
    public function after(): array
    {
        return [
            function ($validator) {
                $category = Category::find($this->validated('category_id'));
                $restaurant = Auth::user()->restaurant;

                // Prüft, ob die Kategorie zum Restaurant UND zum Typ ('food'/'drink') passt.
                if ($category && ($category->restaurant_id !== $restaurant?->id || $category->type !== $this->validated('type'))) {
                    // Wenn nicht, fügen wir eine Fehlermeldung für das 'category_id'-Feld hinzu.
                    $validator->errors()->add(
                        'category_id', 'Die ausgewählte Kategorie ist ungültig oder passt nicht zum Typ.'
                    );
                }
            }
        ];
    }
}