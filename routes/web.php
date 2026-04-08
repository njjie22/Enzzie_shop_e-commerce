<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\MerchController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserArtistController;
use App\Http\Controllers\User\UserShopController;
use App\Http\Controllers\User\UserNotificationController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserMoreController;
use App\Http\Controllers\User\UserMerchController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// ADMIN ROUTES
// =====================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth', RoleMiddleware::class . ':admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/banner/{id}', [BannerController::class, 'show'])->name('banner.show');
        Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
        Route::post('/banner/{id}/update', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('/banner/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');

        Route::get('/artist', [ArtistController::class, 'index'])->name('artist.index');
        Route::post('/artist', [ArtistController::class, 'store'])->name('artist.store');
        Route::put('/artist/{id}', [ArtistController::class, 'update'])->name('artist.update');
        Route::delete('/artist/{id}', [ArtistController::class, 'destroy'])->name('artist.destroy');
        Route::get('/artist/{slug}/detail', [ArtistController::class, 'show'])->name('artist.show');
        Route::post('/artist/{slug}/produk', [ArtistController::class, 'storeProduk'])->name('artist.storeProduk');
        Route::post('/artist/{slug}/kategori', [ArtistController::class, 'storeKategori'])->name('artist.storeKategori');

        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::patch('/order/{id}/status', [OrderController::class, 'updateStatus'])->name('order.status');

        Route::get('/merch', [MerchController::class, 'index'])->name('merch');
        Route::post('/merch', [MerchController::class, 'store'])->name('merch.store');
        Route::get('/merch/{id}', [MerchController::class, 'show'])->name('merch.show');
        Route::post('/merch/{id}', [MerchController::class, 'update'])->name('merch.update');
        Route::delete('/merch/{id}', [MerchController::class, 'destroy'])->name('merch.destroy');
    });

// =====================
// USER ROUTES
// =====================
Route::prefix('user')
    ->name('user.')
    ->middleware(['web', 'auth', RoleMiddleware::class . ':user'])
    ->group(function () {

        // ---------- Dashboard ----------
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/merch/filter', [UserDashboardController::class, 'filterMerch'])->name('merch.filter');

        // ---------- Merch Detail ----------
        Route::get('/merch/{id}', [UserMerchController::class, 'show'])->name('merch.show');

        // ---------- More (Artis & Merch per Artis) ----------
        Route::prefix('more')->name('more.')->group(function () {
            Route::get('/',     [UserMoreController::class, 'index'])->name('index');
            Route::get('/{id}', [UserMoreController::class, 'show'])->name('show');
        });

        // ---------- Artist ----------
        Route::get('/artist', [UserArtistController::class, 'index'])->name('artist.index');
        Route::get('/artist/{slug}', [UserArtistController::class, 'show'])->name('artist.show');

        // ---------- Shop ----------
        Route::get('/shop', [UserShopController::class, 'index'])->name('shop.index');
        Route::get('/shop/{id}', [UserShopController::class, 'show'])->name('shop.show');

        // ---------- Cart ----------
        Route::get('/cart', [UserCartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [UserCartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{id}', [UserCartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{id}', [UserCartController::class, 'remove'])->name('cart.remove');
        Route::delete('/cart', [UserCartController::class, 'clear'])->name('cart.clear');

        // ---------- Order ----------
        Route::get('/order', [UserOrderController::class, 'index'])->name('order.index');
        Route::get('/order/checkout', [UserOrderController::class, 'checkout'])->name('order.checkout');
        Route::post('/order', [UserOrderController::class, 'store'])->name('order.store');
        Route::get('/order/{id}', [UserOrderController::class, 'show'])->name('order.show');
        Route::patch('/order/{id}/cancel', [UserOrderController::class, 'cancel'])->name('order.cancel');
        Route::post('order/buy-now', [UserOrderController::class, 'buyNow'])->name('order.buy-now');

        // ---------- Notifications ----------
        Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read-all', [UserNotificationController::class, 'markAllRead'])->name('notifications.readAll');
        Route::post('/notifications/{id}/read', [UserNotificationController::class, 'markRead'])->name('notifications.read');
        Route::delete('/notifications/{id}', [UserNotificationController::class, 'destroy'])->name('notifications.destroy');

        // ---------- Profile ----------
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
        Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');
       // ---------- Merch Detail ----------
Route::get('/merch/{id}', [UserMerchController::class, 'show'])->name('merch.show');
    });
    