<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVierificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// user all routes

Route::post('/user-registration',[UserController::class,'UserRegistration'])->name('user.registration');
Route::post('/user-login',[UserController::class,'UserLogin'])->name('user.login');


Route::middleware(TokenVierificationMiddleware::class)->group(function(){

    Route::get('/DashboardPage',[UserController::class,'DashboardPage']);
    Route::get('/Logout',[UserController::class,'Logout']);

});
