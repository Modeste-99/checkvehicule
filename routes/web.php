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
use App\Http\Controllers\RappelController;

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

// Termes et conditions
Route::get('/terms', function () {
    return view('auth.terms');
})->name('terms');

// Politique de confidentialité
Route::get('/privacy', function () {
    return view('auth.privacy');
})->name('privacy');

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

    // Rappels
    Route::resource('rappels', RappelController::class)->except(['show']);
    Route::get('rappels-vehicules', [RappelController::class, 'vehiclesWithReminders'])->name('rappels.vehicules');

    // Profil
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
