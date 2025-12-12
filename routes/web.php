<?php

use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// App Controllers
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\GarageController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Routes publiques (non authentifiées)
|--------------------------------------------------------------------------
*/

// Page de connexion
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Page d'inscription
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Déconnexion
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Routes protégées (auth obligatoires)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Véhicules
    Route::resource('vehicules', VehiculeController::class);

    // Entretiens
    Route::resource('entretiens', EntretienController::class);

    // Garages
    Route::resource('garages', GarageController::class);
    Route::get('carte', [GarageController::class, 'carte'])->name('carte');

    // Cours
    Route::resource('cours', CoursController::class);
    Route::get('cours/{cour}/download', [CoursController::class, 'download'])->name('cours.download');

    // Profil
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
