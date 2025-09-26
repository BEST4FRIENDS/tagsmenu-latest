<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Korrekte Namespaces ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicMenuController;
use App\Http\Controllers\Superadmin\ClientController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public & Authentication Routes ---
Route::get('/', function () {
    return view('auth.login');
});
require __DIR__.'/auth.php';


// --- Authenticated User Routes (Customers) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- Routen, die KEIN Abonnement erfordern ---
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/subscribe', [SubscriptionController::class, 'create'])->name('subscribe.create');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscribe.success');
    Route::get('/user/billing-portal', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('dashboard'));
    })->name('billing.portal');

    // --- NEU: API-Endpunkt für KI-Vorschläge ---
    // Diese Route ist hier platziert, da der Controller die Abo-Prüfung selbst durchführt.
    Route::post('/ai/suggest-description', [AiController::class, 'suggestDescription'])->name('ai.suggest.description');

    
    // --- Routen, die ein AKTIVES Abonnement erfordern ---
    Route::middleware(['subscribed'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/qr-code-download', [DashboardController::class, 'downloadQrCode'])->name('qr_code.download');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::resource('dishes', DishController::class);
        Route::resource('categories', CategoryController::class);
    });
});


// --- Superadmin Routes ---
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('clients', ClientController::class)->parameters(['clients' => 'restaurant']);
    Route::patch('/clients/{restaurant}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggleStatus');
});


// --- Public Menu Route (Catch-all) ---
Route::get('/{subdomain}', [PublicMenuController::class, 'show'])->name('public.menu.show');