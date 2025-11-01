<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Laravel\Cashier\Http\Controllers\WebhookController; // Nicht mehr nötig

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- DIESEN BLOCK LÖSCHEN ODER AUSKOMMENTIEREN ---
/*
Route::post(
    '/stripe/webhook',
    [WebhookController::class, 'handleWebhook']
)->name('cashier.webhook');
*/