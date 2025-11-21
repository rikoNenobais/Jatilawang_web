<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


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

// Product reviews endpoints (used by product detail AJAX)
Route::get('/products/{productKey}/reviews', [ProductReviewController::class, 'index'])->name('products.reviews.index');
Route::post('/products/{productKey}/reviews', [ProductReviewController::class, 'store'])->middleware('auth')->name('products.reviews.store');

// Keranjang (boleh guest; simpan di session)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');                 // tambah item
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');    // ubah qty
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy'); // hapus item

// OAuth (placeholder)
Route::get('/auth/redirect/{provider}', fn () => abort(501))->name('social.redirect');


/**
 * -------------------------
 *  AUTHENTICATED ROUTES
 * -------------------------
 */

// Checkout (WAJIB login). Jika belum login, Laravel redirect ke /login dan balik lagi ke /checkout setelah sukses.
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
