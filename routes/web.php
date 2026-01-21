<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController; // <- pievienojam šo
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
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
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::delete('/profile/webinars/{registration}', [ProfileController::class, 'cancelWebinar'])->name('profile.webinars.cancel');
    Route::delete('/profile/bookings/{booking}', [ProfileController::class, 'cancelBooking'])->name('profile.bookings.cancel');
    Route::delete('/profile/orders/{order}', [ProfileController::class, 'cancelOrder'])->name('profile.orders.cancel');

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'bookings'])->name('admin.dashboard');
        Route::get('/admin/overview', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.overview');
        Route::get('/admin/bookings', [\App\Http\Controllers\AdminController::class, 'bookings'])->name('admin.bookings');
        Route::patch('/admin/bookings/{booking}', [\App\Http\Controllers\AdminController::class, 'updateBookingStatus'])->name('admin.bookings.update');

        Route::get('/admin/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
        Route::post('/admin/products', [\App\Http\Controllers\AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::patch('/admin/products/{product}', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::patch('/admin/products/{product}/visibility', [\App\Http\Controllers\AdminController::class, 'toggleProduct'])->name('admin.products.visibility');
        Route::delete('/admin/products/{product}', [\App\Http\Controllers\AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

        Route::patch('/admin/orders/{order}', [\App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.orders.update');

        Route::get('/admin/offers', [\App\Http\Controllers\AdminController::class, 'offers'])->name('admin.offers');
        Route::post('/admin/offers', [\App\Http\Controllers\AdminController::class, 'storeOffer'])->name('admin.offers.store');
        Route::patch('/admin/offers/{offer}', [\App\Http\Controllers\AdminController::class, 'updateOffer'])->name('admin.offers.update');
        Route::delete('/admin/offers/{offer}', [\App\Http\Controllers\AdminController::class, 'destroyOffer'])->name('admin.offers.destroy');
        Route::delete('/admin/offers/registrations/{registration}', [\App\Http\Controllers\AdminController::class, 'destroyRegistration'])->name('admin.offers.registrations.destroy');

        Route::get('/admin/work-items', [\App\Http\Controllers\AdminController::class, 'workItems'])->name('admin.work-items');
        Route::post('/admin/work-items', [\App\Http\Controllers\AdminController::class, 'storeWorkItem'])->name('admin.work-items.store');
        Route::patch('/admin/work-items/{workItem}', [\App\Http\Controllers\AdminController::class, 'updateWorkItem'])->name('admin.work-items.update');
        Route::delete('/admin/work-items/{workItem}', [\App\Http\Controllers\AdminController::class, 'destroyWorkItem'])->name('admin.work-items.destroy');
    });
});

// Pakalpojumi
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Produkti
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/order', [OrderController::class, 'store'])->name('products.order');

Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Mūsu darbi
Route::get('/our-work', function () {
    $workItems = \App\Models\WorkItem::where('is_visible', true)
        ->orderBy('position')
        ->get();

    return view('our-work', compact('workItems'));
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
