<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class TrialBanner extends Component
{
    public int $trialDaysRemaining = 0;
    protected bool $onTrial = false;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = Auth::user();

        // Prüft, ob der User eingeloggt ist und sich in der Testphase befindet (Cashier-Funktion)
        // Wir prüfen Auth::check() explizit als zusätzliche Sicherheit.
        if ($user && Auth::check() && $user->onTrial()) {
            $this->onTrial = true;
            // Berechnet die Tage und rundet auf (ceil), um den aktuellen Tag einzuschließen.
            $this->trialDaysRemaining = (int) ceil(now()->floatDiffInDays($user->trial_ends_at));
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Optimierung: Rendert die View nur, wenn der Banner angezeigt werden soll.
        if ($this->onTrial && $this->trialDaysRemaining > 0) {
            return view('components.trial-banner');
        }

        // Rendert nichts, wenn die Bedingungen nicht erfüllt sind.
        return '';
    }
}