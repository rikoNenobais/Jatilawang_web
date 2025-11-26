<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\SocialiteController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;

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

// Social login (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/callback/{provider}', [SocialiteController::class, 'callback'])->name('social.callback');
});

// Footer
Route::view('/cara-sewa', 'public.cara-sewa')->name('cara-sewa');
Route::view('/cara-pengembalian', 'public.cara-pengembalian')->name('cara-pengembalian');
Route::view('/tentang-kami', 'public.tentang-kami')->name('tentang-kami');
Route::view('/syarat-ketentuan', 'public.s&k')->name('syarat-ketentuan');
Route::view('/kontak', 'public.kontak')->name('kontak');

/**
 * -------------------------
 *  AUTHENTICATED ROUTES - SEMUA USER TERAUTHENTIKASI
 * -------------------------
 */

Route::middleware(['auth'])->group(function () {
    // Profile - untuk semua user (customer & admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/verify', [ProfileController::class, 'verify'])->name('profile.verify');
    Route::get('/profile/edit-form', [ProfileController::class, 'showEditForm'])->name('profile.edit.form');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Profile ganti password - untuk semua user
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password'); 
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

/**
 * -------------------------
 *  CUSTOMER ONLY ROUTES
 * -------------------------
 */

Route::middleware(['auth'])->group(function () {
    // Keranjang - hanya untuk customer
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart_item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart_item}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout - hanya untuk customer
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Payment - hanya untuk customer (UPDATE: pakai transaction_id)
    Route::get('/payment/{transaction}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{transaction}/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.upload-proof');
    
    // Route lama untuk backward compatibility (optional)
    Route::get('/payment', [PaymentController::class, 'showOld'])->name('payment.show.old');

    // Orders - HANYA UNTUK CUSTOMER
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

        // Redirect /admin -> /admin/dashboard
        Route::redirect('/', '/admin/dashboard')->name('home');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Produk / Items
        Route::resource('items', ItemController::class)->except(['show']);

        // Rental
        Route::resource('rentals', RentalController::class)->only(['index', 'show', 'update']);
        Route::post('/rentals/{rental}/denda', [RentalController::class, 'updateDenda'])->name('rentals.update-denda');

        // Buys
        Route::resource('buys', \App\Http\Controllers\Admin\BuyController::class);

        // Transactions (BARU)
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::post('/transactions/{transaction}/verify', [TransactionController::class, 'verify'])->name('transactions.verify');
        Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');

        // User (ubah role) 
        Route::resource('users', UserController::class)->only(['index', 'show']);

        // Review
        Route::resource('reviews', ReviewController::class)->only(['index', 'update', 'destroy']);

        // Financial Report
        Route::get('/financial-report', [DashboardController::class, 'financialReport'])->name('financial-report');

        // Admin Profile (tanpa riwayat pesanan)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile/edit-form', [ProfileController::class, 'showEditForm'])->name('profile.edit.form');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password'); 
        Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

require __DIR__.'/auth.php';