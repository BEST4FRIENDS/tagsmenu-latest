<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prüft, ob eine 'locale' in der Session existiert
        if (Session::has('locale')) {
            // Setzt die Laravel-Anwendungssprache entsprechend
            App::setLocale(Session::get('locale'));
        }
        // Wenn nicht, verwendet Laravel die Standardeinstellung aus config/app.php

        return $next($request);
    }
}