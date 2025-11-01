<?php

namespace App\Policies;

use App\Models\Dish;
use App\Models\User;

class DishPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dish $dish): bool
    {
        // Erlaube die Aktion nur, wenn das Gericht zum Restaurant des Benutzers gehört.
        return $user->restaurant?->id === $dish->category->restaurant_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dish $dish): bool
    {
        // Die Logik ist für das Löschen und Aktualisieren identisch.
        return $this->update($user, $dish);
    }
}