<?php

use Illuminate\Support\Facades\Route;
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

// Checkout (WAJIB login). Jika belum login, Laravel redirect ke /login 
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // prifil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/verify', [ProfileController::class, 'verify'])->name('profile.verify');
    Route::get('/profile/edit-form', [ProfileController::class, 'showEditForm'])->name('profile.edit.form');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // profile ganti pass
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password'); 
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update'); 
    //keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart_item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart_item}', [CartController::class, 'destroy'])->name('cart.destroy');
});

require __DIR__.'/auth.php';
