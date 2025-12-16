<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController; // <- pievienojam šo
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
*/

// Galvenā lapa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autorizācija
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/profile', 'auth.profile')->middleware('auth')->name('profile');

// Pakalpojumi
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Produkti
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/order', [OrderController::class, 'store'])->name('products.order');

// Mūsu darbi
Route::get('/our-work', function () {
    return view('our-work');
})->name('our-work');

/*
|--------------------------------------------------------------------------
| Booking (auto detailing pieraksti)
|--------------------------------------------------------------------------
*/
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| Piedāvājumi / Pasākumi / Vebināri
|--------------------------------------------------------------------------
*/
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::post('/offers/{offer}/signup', [OfferController::class, 'signup'])->name('offers.signup');
