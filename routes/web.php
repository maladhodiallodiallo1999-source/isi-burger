<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;




Route::get('/burgers', [BurgerController::class, 'index']);
Route::get('/burgers/create', [BurgerController::class, 'create']);
Route::post('/burgers', [BurgerController::class, 'store']);
Route::get('/burgers/edit/{id}', [BurgerController::class, 'edit']);
Route::put('/burgers/{id}', [BurgerController::class, 'update']);
Route::get('/burgers/archiver/{id}', [BurgerController::class, 'archiver']);
Route::get('/burgers/desarchiver/{id}', [BurgerController::class, 'desarchiver']);
Route::delete('/burgers/{id}', [BurgerController::class, 'destroy']);



Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/catalogue', [CatalogueController::class, 'index']);

// Routes d'authentification
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Page d'accueil → redirige vers login
Route::get('/', function () {
    return redirect('/login');
});

// Routes client
Route::get('/catalogue', [CommandeController::class, 'catalogue']);
Route::post('/commandes', [CommandeController::class, 'store']);
Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes']);

// Routes gestionnaire
Route::get('/commandes', [CommandeController::class, 'index']);
Route::get('/commandes/{id}', [CommandeController::class, 'show']);
Route::post('/commandes/{id}/statut', [CommandeController::class, 'updateStatut']);
Route::get('/commandes/{id}/annuler', [CommandeController::class, 'annuler']);


Route::get('/commandes/{id}/paiement', [PaiementController::class, 'create']);
Route::post('/commandes/{id}/paiement', [PaiementController::class, 'store']);

Route::get('/commandes/{id}/facture', [CommandeController::class, 'facture']);
