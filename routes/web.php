<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;

/*
|--------------------------------------------------------------------------
| Routes publiques — accessibles sans connexion
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Routes protégées — il faut être connecté (middleware auth)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- Déconnexion ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |----------------------------------------------------------------------
    | Routes CLIENT — catalogue et commandes personnelles
    |----------------------------------------------------------------------
    */

    // Voir le catalogue des burgers
    Route::get('/catalogue', [CommandeController::class, 'catalogue']);

    // Passer une commande
    Route::post('/commandes', [CommandeController::class, 'store']);

    // Voir ses propres commandes
    Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes']);

    /*
    |----------------------------------------------------------------------
    | Routes GESTIONNAIRE — dashboard, burgers, commandes, paiements
    |----------------------------------------------------------------------
    */

    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // --- Gestion des Burgers ---
    Route::get('/burgers', [BurgerController::class, 'index']);           // Liste
    Route::get('/burgers/create', [BurgerController::class, 'create']);   // Formulaire ajout
    Route::post('/burgers', [BurgerController::class, 'store']);          // Enregistrer
    Route::get('/burgers/edit/{id}', [BurgerController::class, 'edit']); // Formulaire modif
    Route::put('/burgers/{id}', [BurgerController::class, 'update']);     // Mettre à jour
    Route::get('/burgers/archiver/{id}', [BurgerController::class, 'archiver']);       // Archiver
    Route::get('/burgers/desarchiver/{id}', [BurgerController::class, 'desarchiver']); // Désarchiver
    Route::delete('/burgers/{id}', [BurgerController::class, 'destroy']); // Supprimer

    // --- Gestion des Commandes ---
    Route::get('/commandes', [CommandeController::class, 'index']);                    // Liste toutes
    Route::get('/commandes/{id}', [CommandeController::class, 'show']);               // Détail
    Route::post('/commandes/{id}/statut', [CommandeController::class, 'updateStatut']); // Changer statut
    Route::get('/commandes/{id}/annuler', [CommandeController::class, 'annuler']);    // Annuler
    Route::get('/commandes/{id}/facture', [CommandeController::class, 'facture']);    // Voir facture

    // --- Gestion des Paiements ---
    Route::get('/commandes/{id}/paiement', [PaiementController::class, 'create']);   // Formulaire paiement
    Route::post('/commandes/{id}/paiement', [PaiementController::class, 'store']);   // Enregistrer paiement

});
