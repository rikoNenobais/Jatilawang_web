<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;

/**
 * -------------------------
 *  PUBLIC ROUTES (guest)
 * -------------------------
 */

// Landing page (halaman depan seperti mockup)
Route::get('/', [ProductController::class, 'home'])->name('home');

// Katalog & detail produk (publik bisa lihat)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{item_name}', [ProductController::class, 'show'])->name('products.show');

// Product reviews endpoints 
Route::get('/products/{productKey}/reviews', [ProductReviewController::class, 'index'])->name('products.reviews.index');
Route::post('/products/{productKey}/reviews', [ProductReviewController::class, 'store'])->middleware('auth')->name('products.reviews.store');

// Keranjang (boleh guest; simpan di session)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');                 // tambah item
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');    // ubah qty
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy'); // hapus item

// OAuth (placeholder)
Route::get('/auth/redirect/{provider}', fn () => abort(501))->name('social.redirect');

// Footer
Route::view('/cara-sewa', 'public.cara-sewa')->name('cara-sewa');
Route::view('/cara-pengembalian', 'public.cara-pengembalian')->name('cara-pengembalian');
Route::view('/tentang-kami', 'public.tentang-kami')->name('tentang-kami');
Route::view('/syarat-ketentuan', 'public.s&k')->name('syarat-ketentuan');
Route::view('/kontak', 'public.kontak')->name('kontak');

/**
 * -------------------------
 *  AUTHENTICATED ROUTES
 * -------------------------
 */

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/verify', [ProfileController::class, 'verify'])->name('profile.verify');
    Route::get('/profile/edit-form', [ProfileController::class, 'showEditForm'])->name('profile.edit.form');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Profile ganti password
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password'); 
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update'); 
    
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart_item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart_item}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout 
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Payment
    Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.upload-proof');

    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
});

/**
 * -------------------------
 *  ADMIN ROUTES
 * -------------------------
 */
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // /admin
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Produk / Items
        Route::resource('items', ItemController::class)->except(['show']);

        // Rental
        Route::resource('rentals', RentalController::class)->only(['index', 'show', 'update']);

        // User (ubah role)
        Route::resource('users', UserController::class)->only(['index', 'show']);

        // Review
        Route::resource('reviews', ReviewController::class)->only(['index', 'update', 'destroy']);
    });

require __DIR__.'/auth.php';