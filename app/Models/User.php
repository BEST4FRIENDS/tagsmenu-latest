<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'trial_ends_at', // HINZUGEFÜGT
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'trial_ends_at' => 'datetime',
        ];
    }

    /**
     * Get the restaurant associated with the user.
     */
    public function restaurant(): HasOne
    {
        return $this->hasOne(Restaurant::class);
    }

    /**
     * Get the human-readable name of the user's subscribed plan.
     * This function translates a Stripe Price ID into a friendly name
     * using the mapping defined in config/services.php.
     *
     * @return string|null
     */
    public function getPlanName(): ?string
    {
        $subscription = $this->subscriptions->first();

        if (! $subscription) {
            return null;
        }

        $priceId = $subscription->stripe_price;

        // Look up the friendly name in our config file.
        // The '?? $priceId' part is a fallback: if we ever forget to add a
        // name, it will just show the ID instead of causing an error. // <-- DIESER KOMMENTAR WURDE KORRIGIERT
        return config('services.stripe.plans')[$priceId] ?? $priceId;
    }
}