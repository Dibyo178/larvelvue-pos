<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// user all routes

Route::post('/user-registration',[UserController::class,'UserRegistration'])->name('user.registration');
Route::post('/user-login',[UserController::class,'UserLogin'])->name('user.login');
