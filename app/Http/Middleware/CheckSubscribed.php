<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscribed
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $user = $request->user()) {
            return redirect()->route('login');
        }

        // NEU: Prüfung auf den "einmaligen VIP-Pass"
        if ($request->session()->has('newly_subscribed')) {
            // Wenn der Pass existiert, entfernen wir ihn sofort wieder,
            // damit er nur dieses eine Mal gültig ist.
            $request->session()->forget('newly_subscribed');
            
            // Und wir lassen den Benutzer sofort passieren, ohne weitere Abo-Prüfung.
            return $next($request);
        }

        // VIP-Check für Superadmins (bleibt unverändert)
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Normaler Kunden-Check (bleibt unverändert)
        if (! $user->subscribed('default')) {
            return redirect()->route('plans.index')->with('error', 'Sie benötigen ein aktives Abonnement, um auf diese Seite zuzugreifen.');
        }

        return $next($request);
    }
}