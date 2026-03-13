<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FreelanceController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\MissionController as ClientMission;
use App\Http\Controllers\Freelance\DashboardController as FreelanceDashboard;
use App\Http\Controllers\Freelance\PropositionController;
use App\Http\Controllers\Freelance\ProfilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\MissionController as AdminMission;

// -------------------------------------------------------
// Routes publiques
// -------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/missions', [MissionController::class, 'index'])->name('missions.index');
Route::get('/missions/{mission}', [MissionController::class, 'show'])->name('missions.show');
Route::get('/freelances', [FreelanceController::class, 'index'])->name('freelances.index');
Route::get('/freelances/{user}', [FreelanceController::class, 'show'])->name('freelances.show');

// -------------------------------------------------------
// Auth (Breeze)
// -------------------------------------------------------
require __DIR__.'/auth.php';

// -------------------------------------------------------
// Routes CLIENT
// -------------------------------------------------------
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');

    // Missions
    Route::get('/missions', [ClientMission::class, 'index'])->name('missions.index');
    Route::get('/missions/create', [ClientMission::class, 'create'])->name('missions.create');
    Route::post('/missions', [ClientMission::class, 'store'])->name('missions.store');
    Route::get('/missions/{mission}/edit', [ClientMission::class, 'edit'])->name('missions.edit');
    Route::put('/missions/{mission}', [ClientMission::class, 'update'])->name('missions.update');
    Route::delete('/missions/{mission}', [ClientMission::class, 'destroy'])->name('missions.destroy');

    // Propositions reçues
    Route::get('/missions/{mission}/propositions', [ClientMission::class, 'propositions'])
        ->name('missions.propositions');
    Route::patch('/propositions/{proposition}/accepter', [ClientMission::class, 'accepterProposition'])
        ->name('propositions.accepter');
    Route::patch('/propositions/{proposition}/refuser', [ClientMission::class, 'refuserProposition'])
        ->name('propositions.refuser');
});

// -------------------------------------------------------
// Routes FREELANCE
// -------------------------------------------------------
Route::middleware(['auth', 'freelance'])->prefix('freelance')->name('freelance.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [FreelanceDashboard::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // Propositions
    Route::post('/missions/{mission}/proposer', [PropositionController::class, 'store'])
        ->name('propositions.store');
    Route::get('/propositions', [PropositionController::class, 'index'])->name('propositions.index');
    Route::delete('/propositions/{proposition}', [PropositionController::class, 'destroy'])
        ->name('propositions.destroy');
});

// -------------------------------------------------------
// Routes ADMIN
// -------------------------------------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Utilisateurs
    Route::get('/users', [AdminUser::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUser::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle', [AdminUser::class, 'toggle'])->name('users.toggle');

    // Missions
    Route::get('/missions', [AdminMission::class, 'index'])->name('missions.index');
    Route::delete('/missions/{mission}', [AdminMission::class, 'destroy'])->name('missions.destroy');
    Route::patch('/missions/{mission}/toggle', [AdminMission::class, 'toggle'])->name('missions.toggle');
});

// -------------------------------------------------------
// Routes MESSAGES (auth requis)
// -------------------------------------------------------
Route::middleware('auth')->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/{user}', [MessageController::class, 'conversation'])->name('conversation');
    Route::post('/{user}', [MessageController::class, 'send'])->name('send');
});