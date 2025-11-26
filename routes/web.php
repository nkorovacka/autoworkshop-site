<?php
use App\Http\Controllers\OfferController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Galvenā lapa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pakalpojumi
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Produkti
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Mūsu darbi
Route::get('/our-work', function () {
    return view('our-work');
})->name('our-work');

// Booking (pagaidām vienkārša lapa)
// Booking forma
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/offers', function () {
    return view('offers');
})->name('offers');
// Piedāvājumi / pasākumi
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::post('/offers/{offer}/signup', [OfferController::class, 'signup'])->name('offers.signup');

