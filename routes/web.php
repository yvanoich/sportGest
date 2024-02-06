<?php

use Illuminate\Support\Facades\Route;

//require du controller
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//page d'accueil
Route::get('/', [AccueilController::class, 'afficherAccueil']);

//inscription
Route::get('/inscription', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/inscription', [RegisterController::class, 'register']);

//recup les routes d'authentification
Auth::routes();

//affichage de la page statistiques
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//page profil
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'getProfile'])->name('profile');
Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'setProfile'])->name('profile-set');

//Activity
Route::get('/get/activity/{ident?}', [App\Http\Controllers\ActivityController::class, 'getActivity'])->name('activity-get');
Route::post('/set/activity/{ident?}', [App\Http\Controllers\ActivityController::class, 'setActivity'])->name('activity-set');