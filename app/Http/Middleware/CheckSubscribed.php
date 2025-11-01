<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) return redirect()->route('login');

        // 1. Superadmins dürfen immer passieren
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // 2. Prüfen, ob abonniert ODER ob sich der User in der Testphase befindet.
        // Cashier bietet die Methode onTrial(), die die Spalte trial_ends_at prüft.
        if ($user->subscribed('default') || $user->onTrial()) {
            return $next($request);
        }

        // 3. Wenn nicht abonniert UND Testphase abgelaufen, zur Tarifauswahl umleiten
        session()->flash('error', 'Ihre Testphase ist abgelaufen. Bitte wählen Sie einen Tarif, um fortzufahren.');
        return redirect()->route('plans.index');
    }
}