<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        // Erlaube die Aktion nur, wenn die Restaurant-ID der Kategorie
        // mit der Restaurant-ID des angemeldeten Benutzers übereinstimmt.
        return $user->restaurant?->id === $category->restaurant_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        // Wir verwenden für das Löschen die gleiche Logik wie für das Aktualisieren.
        return $this->update($user, $category);
    }
}