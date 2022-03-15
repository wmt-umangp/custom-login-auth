<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;


Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('post-login', [CustomAuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register');
Route::post('post-registration', [CustomAuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
Route::get('logout', [CustomAuthController::class, 'logout'])->name('logout');
