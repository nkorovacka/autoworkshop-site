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

// Galvenā lapa (publiskais sākums)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autorizācija (login/register/logout + profils)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
// Paroles atjaunošana (aizmirstas paroles plūsma)
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    // Profila sadaļa un lietotāja darbības
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::delete('/profile/webinars/{registration}', [ProfileController::class, 'cancelWebinar'])->name('profile.webinars.cancel');
    Route::delete('/profile/bookings/{booking}', [ProfileController::class, 'cancelBooking'])->name('profile.bookings.cancel');
    Route::delete('/profile/orders/{order}', [ProfileController::class, 'cancelOrder'])->name('profile.orders.cancel');

    // Admin panelis (tikai adminiem)
    Route::middleware('admin')->group(function () {
        // Admin sākumlapa un kopsavilkums
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'bookings'])->name('admin.dashboard');
        // Pakalpojumu pieteikumu pārvaldība
        Route::get('/admin/bookings', [\App\Http\Controllers\AdminController::class, 'bookings'])->name('admin.bookings');
        Route::patch('/admin/bookings/{booking}', [\App\Http\Controllers\AdminController::class, 'updateBookingStatus'])->name('admin.bookings.update');

        // Produktu pārvaldība admin panelī
        Route::get('/admin/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
        Route::post('/admin/products', [\App\Http\Controllers\AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::patch('/admin/products/{product}', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::patch('/admin/products/{product}/visibility', [\App\Http\Controllers\AdminController::class, 'toggleProduct'])->name('admin.products.visibility');
        Route::delete('/admin/products/{product}', [\App\Http\Controllers\AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

        // Pasūtījumu statusu maiņa
        Route::patch('/admin/orders/{order}', [\App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.orders.update');

        // Piedāvājumu/vebināru pārvaldība
        Route::get('/admin/offers', [\App\Http\Controllers\AdminController::class, 'offers'])->name('admin.offers');
        Route::post('/admin/offers', [\App\Http\Controllers\AdminController::class, 'storeOffer'])->name('admin.offers.store');
        Route::patch('/admin/offers/{offer}', [\App\Http\Controllers\AdminController::class, 'updateOffer'])->name('admin.offers.update');
        Route::delete('/admin/offers/{offer}', [\App\Http\Controllers\AdminController::class, 'destroyOffer'])->name('admin.offers.destroy');
        Route::delete('/admin/offers/registrations/{registration}', [\App\Http\Controllers\AdminController::class, 'destroyRegistration'])->name('admin.offers.registrations.destroy');

        // "Mūsu darbi" sadaļas pārvaldība
        Route::get('/admin/work-items', [\App\Http\Controllers\AdminController::class, 'workItems'])->name('admin.work-items');
        Route::post('/admin/work-items', [\App\Http\Controllers\AdminController::class, 'storeWorkItem'])->name('admin.work-items.store');
        Route::patch('/admin/work-items/{workItem}', [\App\Http\Controllers\AdminController::class, 'updateWorkItem'])->name('admin.work-items.update');
        Route::delete('/admin/work-items/{workItem}', [\App\Http\Controllers\AdminController::class, 'destroyWorkItem'])->name('admin.work-items.destroy');

        // Lietotāju pārvaldība admin panelī
        Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::patch('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });
});

// Pakalpojumi (publiskais katalogs)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Produkti (katalogs un produkta lapa)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/order', [OrderController::class, 'store'])->name('products.order');

Route::middleware('auth')->group(function () {
    // Grozs
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Mūsu darbi (publiska galerija)
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
// Rezervācijas forma un saglabāšana
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| Piedāvājumi / Pasākumi / Vebināri
|--------------------------------------------------------------------------
*/
// Piedāvājumu saraksts un pieteikšanās
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::post('/offers/{offer}/signup', [OfferController::class, 'signup'])->name('offers.signup');
