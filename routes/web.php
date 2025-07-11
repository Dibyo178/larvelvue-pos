<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVierificationMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/test',[HomeController::class,'test'])->name('testPage');

// user all routes

Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');
Route::post('/send-otp', [UserController::class, 'SendOTPCode'])->name('SendOTPCode');
Route::post('/verify-otp', [UserController::class, 'VerifyOTP'])->name('VerifyOTP');

Route::middleware(TokenVierificationMiddleware::class)->group(function () {

    Route::post('/reset-password', [UserController::class, 'ResetPassword']);
    Route::get('/DashboardPage', [UserController::class, 'DashboardPage']);
    Route::get('/Logout', [UserController::class, 'Logout']);

    //Category all routes
    Route::post('/create-category', [CategoryController::class, 'CreateCategory'])->name('category.create');
    Route::get('/list-category', [CategoryController::class, 'CategoryList'])->name('category.list');
    Route::post('/category-by-id', [CategoryController::class, 'CategoryById']);
    Route::post('/update-category', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::get('/delete-category/{id}', action: [CategoryController::class, 'CategoryDelete'])->name('category.delete');

    //Product all routes
    Route::post('/create-product', [ProductController::class, 'CreateProduct'])->name('CreateProduct');
    Route::get('/list-product', [ProductController::class, 'ProductList'])->name('ProductList');
    Route::post('/product-by-id', [ProductController::class, 'ProductById'])->name('ProductById');
    Route::post('/update-product', [ProductController::class, 'ProductUpdate'])->name('ProductUpdate');
    Route::get('/delete-product/{id}', action: [ProductController::class, 'ProductDelete'])->name('ProductDelete');

    //Profile all routes
    Route::post('/create-customer', [CustomerController::class, 'CreateCustomer'])->name('CreateCustomer');
    Route::get('/list-customer', [CustomerController::class, 'CustomerList'])->name('CustomerList');
    Route::post('/customer-by-id', [CustomerController::class, 'CustomerById'])->name('CustomerById');
    Route::post('/update-customer', [CustomerController::class, 'CustomerUpdate'])->name('CustomerUpdate');
    Route::get('/delete-customer/{id}', [CustomerController::class, 'CustomerDelete'])->name('CustomerDelete');
    Route::get('/CustomerPage', [CustomerController::class, 'CustomerPage'])->name('CustomerPage');
    Route::get('/CustomerSavePage', [CustomerController::class, 'CustomerSavePage'])->name('CustomerSavePage');

        //Invoice all routes
    Route::post('/invoice-create', [InvoiceController::class, 'InvoiceCreate'])->name('InvoiceCreate');
    Route::get('/invoice-list', [InvoiceController::class, 'InvoiceList'])->name('InvoiceList');
    Route::post('/invoice-details', [InvoiceController::class, 'InvoiceDetails'])->name('InvoiceDetails');
    Route::get('/invoice-delete/{id}', [InvoiceController::class, 'InvoiceDelete'])->name('InvoiceDelete');
    Route::get('/InvoiceListPage', [InvoiceController::class, 'InvoiceListPage'])->name('InvoiceListPage');


    //Dashboard Summary

    Route::get('/dashboard-summary', action: [DashboardController::class, 'DashboardSummary'])->name('DashboardSummary');


});
