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
Route::post('/send-otp', [UserController::class, 'SendOTPCode'])->name('SendOTPCode');
Route::post('/verify-otp', [UserController::class, 'VerifyOTP'])->name('VerifyOTP');

Route::middleware(TokenVierificationMiddleware::class)->group(function(){

    Route::post('/reset-password', [UserController::class, 'ResetPassword']);
    Route::get('/DashboardPage',[UserController::class,'DashboardPage']);
    Route::get('/Logout',[UserController::class,'Logout']);

});
