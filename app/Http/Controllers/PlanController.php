<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display the list of available subscription plans.
     */
    public function index(): View
    {
        // 1. Lade die Plan-IDs aus der Konfigurationsdatei (config/services.php)
        $stripePlans = config('services.stripe.plans');

        // 2. Übergib die IDs als einzelne Variablen an die View.
        //    Die View kann dann auf $basicPlanId, $premiumPlanId etc. zugreifen.
        return view('plans.index', [
            'basicPlanId'     => $stripePlans['basic'],
            'premiumPlanId'   => $stripePlans['premium'],
            'conciergePlanId' => $stripePlans['concierge'],
        ]);
    }
}