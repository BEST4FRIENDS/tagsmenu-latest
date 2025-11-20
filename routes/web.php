<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Namespaces ---
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
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\PublicAiController;
use App\Http\Controllers\LanguageController;
use App\Livewire\StaffInterface;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Superadmin\PortalCategoryController;

// NEU: Import für den Superadmin PostController mit Alias
use App\Http\Controllers\Superadmin\PostController as SuperadminPostController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| WICHTIG: Die Reihenfolge ist entscheidend! Spezifische Routen müssen
| immer VOR allgemeinen "Catch-all"-Routen definiert werden.
|
| Domain-Struktur:
| - app.tagsmenu.app -> Admin Dashboard (Login, Dashboard, Settings, Superadmin)
| - tagsmenu.app -> Public Portal (Home, Search, Blog, Restaurant Hubs)
| - {restaurant}.tagsmenu.app -> Individual Restaurant Menus (via subdomain)
|--------------------------------------------------------------------------
*/

// --- Admin Dashboard Routes (app.tagsmenu.app) ---
Route::domain(config('app.domain_admin'))->group(function () {
    // Authentifizierungs-Routen
    require __DIR__.'/auth.php';

    // Authenticated User Routes (Customers)
    Route::middleware(['auth', 'verified'])->group(function () {
        // Routen, die KEIN Abonnement erfordern
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/subscribe', [SubscriptionController::class, 'create'])->name('subscribe.create');
        Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscribe.success');
        Route::post('/ai/suggest-description', [AiController::class, 'suggestDescription'])->name('ai.suggest.description');

        // Routen, die ein AKTIVES Abonnement erfordern
        Route::middleware(['subscribed'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/qr-code-download', [DashboardController::class, 'downloadQrCode'])->name('qr_code.download');

            // Profile
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // Einstellungen
            Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
            Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

            // Stripe Billing Portal
            Route::get('/billing-portal', [SettingsController::class, 'billingPortal'])->name('billing.portal');

            // Resources
            Route::resource('dishes', DishController::class);
            Route::resource('categories', CategoryController::class);

            // Daten-Import
            Route::get('/imports', [ImportController::class, 'index'])->name('imports.index');
            Route::post('/imports/upload', [ImportController::class, 'upload'])->name('imports.upload');
            Route::get('/imports/download-template', [ImportController::class, 'downloadTemplate'])->name('imports.downloadTemplate');
        });
    });

    // Superadmin Routes
    Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::resource('clients', ClientController::class)->parameters(['clients' => 'restaurant']);
        Route::patch('/clients/{restaurant}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggleStatus');
        Route::resource('portal-categories', PortalCategoryController::class);
        Route::resource('posts', SuperadminPostController::class);
    });
});

// --- Public Portal Routes (tagsmenu.app) ---
// --- 1. Spezifische öffentliche Routen ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('blog.show');

// KORREKTE POSITION: Die Route für den Sprachwechsel muss öffentlich sein
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// --- 3. Andere spezifische, öffentliche Routen mit festen Prefixen ---
Route::get('/staff/{token}', StaffInterface::class)->name('staff.index');


// --- 6. API-artige Interaktions-Routen ---
Route::post('/interact/like/{dish}', [InteractionController::class, 'likeDish'])->name('interact.like');
Route::post('/public-ai/poetic-description/{dish}', [PublicAiController::class, 'getPoeticDescription'])->name('public.ai.poetic');


// --- 7. Public Menu Route (Subdomain-Struktur) ---
Route::get('/m/{subdomain}', [PublicMenuController::class, 'show'])->name('public.menu.show');


// --- 8. DIE ALLGEMEINE CATCH-ALL ROUTE (MUSS GANZ AM ENDE STEHEN!) ---
// Diese Route fängt alles ab, was nicht zu den obigen, spezifischeren Routen passt.
Route::get('/{restaurant:seo_slug}', [HubController::class, 'show'])->name('hubs.show');