<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;
// NEU: Imports für Beziehungen und Scout
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Restaurant extends Model
{
    // NEU: Searchable Trait hinzufügen
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'subdomain',
        'logo_url',
        'user_id',
        'status',
        'currency',
        'contact_email',
        'contact_phone',
        'address',
        'accent_color',
        'seo_title',
        'meta_description',
        'og_image_url',
        'social_links',
        'staff_access_token',
        // NEU: Felder für die Discovery Plattform
        'is_publicly_listed',
        'seo_slug',
        'about_us',
        'cover_image_path',
        'latitude',
        'longitude',
        'is_featured', 
    ];

    /**
     * VERBESSERUNG: Diese Eigenschaft sorgt dafür, dass die 'updated_at' Zeit des Restaurants
     * aktualisiert wird, wenn eine zugehörige Kategorie gespeichert wird.
     * Nützlich z.B. für Cache-Invalidierung.
     *
     * @var array
     */
    protected $touches = ['categories'];

    /**
     * Wichtig: Cast für das JSON-Feld definieren.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'is_publicly_listed' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_featured' => 'boolean', // NEU HINZUGEFÜGT
        ];
    }

    /**
     * NEU: Boot-Methode, um den Token bei der Erstellung automatisch zu generieren.
     */
    protected static function boot()
    {
        parent::boot();

        // Stellt sicher, dass ein Token generiert wird, wenn ein neues Restaurant erstellt wird
        static::creating(function ($restaurant) {
            if (empty($restaurant->staff_access_token)) {
                $restaurant->staff_access_token = Str::random(64);
            }
        });
    }

    // --- Beziehungen (Bestehend) ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function dishes(): HasManyThrough
    {
        return $this->hasManyThrough(Dish::class, Category::class);
    }

    // --- NEU: Portal Beziehungen ---

    /**
     * NEU: Get the Portal Categories (z.B. "Italienisch", "Bar").
     */
    public function portalCategories(): BelongsToMany
    {
        // Wichtig: Der zweite Parameter muss dem Namen der Pivot-Tabelle entsprechen.
        return $this->belongsToMany(PortalCategory::class, 'portal_category_restaurant');
    }

    /**
     * NEU: Get the Hashtags for the restaurant (z.B. "#Terrasse"). Polymorphe Beziehung.
     */
    public function hashtags(): MorphToMany
    {
        return $this->morphToMany(Hashtag::class, 'taggable');
    }

    // --- Hinzugefügte Methode ---

    /**
     * NEU: Hilfsmethode, um die Adresse für das Geocoding zusammenzufassen.
     */
    public function getFullAddress(): string
    {
        // Annahme: Ihre Adresse ist im Feld 'address' gespeichert.
        // Wenn Sie separate Felder (street, city, zip) nutzen, müssen diese hier zusammengefügt werden.
        return $this->address ?? '';

        // Beispiel für separate Felder:
        // return $this->street . ', ' . $this->zip_code . ' ' . $this->city;
    }

    // --- Scout / Meilisearch Konfiguration ---

    /**
     * NEU: Definiert, welche Daten an Meilisearch gesendet werden.
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // 1. Geodaten (Essenziell für Umkreissuche)
        // Meilisearch benötigt das _geo Objekt.
        if ($this->latitude && $this->longitude) {
            $array['_geo'] = [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }

        // 2. Beziehungen für Filterung (Facets)
        // Wir laden die Namen, damit wir später danach filtern können.
        $array['hashtags'] = $this->hashtags->pluck('name')->toArray();
        $array['categories'] = $this->portalCategories->pluck('name')->toArray();

        // Entfernen von sensiblen Daten, die nicht durchsuchbar sein sollen
        unset($array['staff_access_token'], $array['user_id']);

        return $array;
    }

    /**
     * NEU: Bestimmt, ob das Model durchsuchbar sein soll.
     * Nur Restaurants indizieren, die öffentlich gelistet sind.
     */
    public function shouldBeSearchable(): bool
    {
        // Wenn 'is_publicly_listed' null ist, wird 'false' zurückgegeben.
        return $this->is_publicly_listed ?? false;
    }

    /**
     * Erstellt die vollständige URL zur Subdomain des Restaurants.
     * Dies ist ein Accessor, der über $restaurant->subdomain_url aufgerufen wird.
     */
    public function getSubdomainUrlAttribute(): string
    {
        // Holt die Basis-Domain aus der .env-Datei (z.B. tagsmenu.app)
        $baseDomain = config('app.domain_base');

        // Baut die URL zusammen. Passt das Protokoll an, falls nötig.
        $protocol = request()->isSecure() ? 'https' : 'http';

        return "{$protocol}://{$this->subdomain}.{$baseDomain}";
    }
}