<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Gestionnaire\DashboardController;
use App\Http\Controllers\Gestionnaire\PaiementsController;
use App\Http\Controllers\Gestionnaire\StatistiquesController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Gestionnaire\CommandeController as GestionnaireCommandeController;
use App\Http\Controllers\Gestionnaire\PaiementController;
use App\Http\Controllers\Gestionnaire\StatistiqueController;
use App\Http\Controllers\Client\CommandeController as ClientCommandeController;
use App\Http\Controllers\CatalogueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes d'authentification
Auth::routes();

// Redirection après connexion
Route::get('/home', function () {
    return redirect()->route('catalogue.index');
})->name('home');

// Routes publiques pour le catalogue
Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/catalogue/{burger}', [CatalogueController::class, 'show'])->name('catalogue.show');
Route::get('/catalogue/filter', [BurgerController::class, 'filter'])->name('catalogue.filter');

// Routes protégées pour les clients
Route::middleware(['auth'])->group(function () {
    // Dashboard client
    Route::get('/client/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])
        ->name('client.dashboard');
    
    // Commandes
    Route::get('/mes-commandes', [CommandeController::class, 'index'])->name('client.commandes.index');
    Route::get('/mes-commandes/{commande}', [CommandeController::class, 'show'])->name('client.commandes.show');
    Route::post('/commander', [CommandeController::class, 'store'])->name('client.commandes.store');
    
    // Profil
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
});

// Routes pour le gestionnaire
Route::middleware(['auth', 'role:gestionnaire'])->prefix('gestionnaire')->name('gestionnaire.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour les burgers
    Route::resource('burgers', BurgerController::class);
    
    // Routes pour les commandes du gestionnaire
    Route::get('/commandes', [GestionnaireCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [GestionnaireCommandeController::class, 'show'])->name('commandes.show');
    Route::put('/commandes/{commande}/status', [GestionnaireCommandeController::class, 'updateStatus'])
        ->name('commandes.status.update');
    Route::put('/commandes/{commande}/cancel', [GestionnaireCommandeController::class, 'cancel'])->name('commandes.cancel');
    
    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::post('/commandes/{commande}/paiement', [PaiementController::class, 'store'])->name('paiements.store');
    
    Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
    Route::get('/statistiques/commandes-journalieres', [StatistiquesController::class, 'commandesJournalieres'])->name('statistiques.commandes-journalieres');
    Route::get('/statistiques/ventes-mensuelles', [StatistiquesController::class, 'ventesMensuelles'])->name('statistiques.ventes-mensuelles');
    Route::get('/statistiques/produits-categories', [StatistiquesController::class, 'produitsCategories'])->name('statistiques.produits-categories');
});

// Routes pour les notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/{notification}/mark-as-read', function ($id) {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();
        return back();
    })->name('notifications.markAsRead');

    Route::get('/notifications/mark-all-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllAsRead');
});

// Routes pour le panier
Route::post('/catalogue/ajouter-panier/{burger}', [CatalogueController::class, 'ajouterAuPanier'])->name('catalogue.ajouterAuPanier');
