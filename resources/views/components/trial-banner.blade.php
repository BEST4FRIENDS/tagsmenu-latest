{{-- resources/views/components/trial-banner.blade.php --}}
<div class="bg-blue-600 text-white p-3 text-center text- m font-medium">
    <div>
        {{-- Einführungstext (Übersetzt) --}}
        {{-- Wir verwenden <span> hier, um sicherzustellen, dass der Textfluss erhalten bleibt. --}}
        <span>{{ __('dashboard.trial_banner_intro') }}</span>
        
        {{-- Tage verbleibend (Pluralisiert und Übersetzt) --}}
        {{-- Styling Korrektur: Entfernt mx-1 für originalgetreuen Abstand (der Abstand kommt durch den Zeilenumbruch im HTML) --}}
        <strong>
            {{ trans_choice('dashboard.trial_banner_days_remaining', $trialDaysRemaining, ['count' => $trialDaysRemaining]) }}.
        </strong>

        {{-- Call to Action (Übersetzt) --}}
        {{-- Styling Korrektur: Entfernt font-semibold und setzt Hover-Farbe auf hover:text-blue-200 zurück --}}
        <a href="{{ route('plans.index') }}" class="underline hover:text-blue-200 ml-2">
            {{ __('dashboard.trial_banner_cta') }} &rarr;
        </a>
    </div>
</div>