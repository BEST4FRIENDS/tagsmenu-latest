<?php

namespace App\Providers;

// HINZUGEFÜGT: Notwendige Klassen für die Verbesserungen
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // VERBESSERUNG 1: Schaltet strikte Entwicklungs-Modi für Eloquent an.
        // Dies hilft, häufige Fehler (N+1-Problem, Mass-Assignment) frühzeitig zu finden.
        // Es ist nur aktiv, wenn die App NICHT im Produktionsmodus ('production') läuft.
        Model::shouldBeStrict(! $this->app->isProduction());

        // VERBESSERUNG 2: Erzwingt HTTPS für alle generierten URLs,
        // wenn die App im Produktionsmodus läuft. Wichtig, wenn die App
        // hinter einem Proxy oder Load Balancer betrieben wird.
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
        
        // VERBESSERUNG 3: Legt die Standard-Sprache für die gesamte Anwendung fest.
        // Nützlich für Übersetzungen (z.B. in lang-Dateien) und Datumsformatierungen.
        App::setLocale('de');

        // VERBESSERUNG 4: Teilt Laravel mit, dass für die Paginierung (Seitennummerierung)
        // die HTML-Struktur von Bootstrap 5 verwendet werden soll.
        Paginator::useBootstrapFive();
    }
}