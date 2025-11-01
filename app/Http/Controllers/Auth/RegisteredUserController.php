<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\View\View; // HINZUGEFÜGT: Notwendig für den return type der create() Methode

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * HINZUGEFÜGT: Diese Methode hat gefehlt.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validierung (User + Restaurant Name)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'restaurant_name' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        // NEU: 2. Eindeutige Subdomain generieren
        $baseSubdomain = Str::slug($request->restaurant_name);
        $subdomain = $baseSubdomain;
        $counter = 1;

        // Prüfen, ob die Subdomain bereits existiert und eindeutig machen
        // Wir verwenden DB::table für eine effiziente Prüfung.
        while (DB::table('restaurants')->where('subdomain', $subdomain)->exists()) {
            $subdomain = $baseSubdomain . '-' . $counter;
            $counter++;
        }

        // 3. Transaktion starten
        DB::beginTransaction();

        try {
            // 4. Benutzer erstellen und Testphase initialisieren
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'trial_ends_at' => Carbon::now()->addDays(14),
            ]);

            // 5. Restaurant erstellen (Sofort aktiv für die Testphase)
            $user->restaurant()->create([
                'name' => $request->restaurant_name,
                'status' => 'active',
                'subdomain' => $subdomain, // HINZUGEFÜGT: Eindeutige Subdomain
            ]);

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            // 6. Weiterleitung zum Dashboard
            return redirect()->route('dashboard')->with('success', 'Willkommen bei TAGS.MENU! Ihre 14-tägige Testphase hat begonnen.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Registration failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Registrierung fehlgeschlagen. Bitte versuchen Sie es erneut.'])->withInput();
        }
    }
}