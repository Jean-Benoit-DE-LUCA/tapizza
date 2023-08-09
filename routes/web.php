<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ResetPasswordController;

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

Route::get('/', [HomeController::class, 'homeAction'])->name('home');

Route::get('/inscription', [RegisterController::class, 'registerAction'])->name('register');
Route::post('/inscription', [RegisterController::class, 'registerPostAction'])->name('registerPost');

Route::get('/connexion', [ConnectionController::class, 'connectionAction'])->name('connection');
Route::post('/connexion', [ConnectionController::class, 'connectionPostAction'])->name('connectionPost');
Route::get('/deconnexion', [ConnectionController::class, 'disconnectionAction'])->name('disconnection');

Route::get('/propositions', [PizzaController::class, 'proposalsAction'])->name('propositions');

Route::get('/tapizza', [PizzaController::class, 'yourPizzaAction'])->name('tapizza');

Route::get('/commande', [OrderController::class, 'orderAction'])->middleware(['auth-custom'])->name('order');
Route::post('/commande', [OrderController::class, 'orderPostAction'])->middleware(['auth-custom'])->name('orderPost');

Route::get('/profile', [ProfileController::class, 'profileAction'])->middleware(['auth-custom'])->name('profile');
Route::post('/profile', [ProfileController::class, 'profilePostAction'])->middleware(['auth-custom'])->name('profilePost');

Route::get('/contact', [ContactController::class, 'contactAction'])->name('contact');
Route::post('/contact', [ContactController::class, 'contactPostAction'])->name('contactPost');

Route::get('/mail', [ResetPasswordController::class, 'mailAction'])->name('mail');
Route::post('/mail', [ResetPasswordController::class, 'mailPostAction'])->name('mailPost');
Route::get('/motdepasse', [ResetPasswordController::class, 'resetPasswordAction'])->name('resetPassword');
Route::post('/motdepasse', [ResetPasswordController::class, 'resetPasswordPostAction'])->name('resetPasswordPost');