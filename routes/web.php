<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Buyer\TransactionController as BuyerTransactionController;
use App\Http\Controllers\Seller\TransactionController as SellerTransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Rute publik (tanpa autentikasi)
Route::get('/', [LandController::class, 'publicIndex'])
    ->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.authenticate')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process')->middleware('guest');

// Rute yang memerlukan autentikasi dan peran spesifik
Route::middleware(['auth'])->group(function () {
    // Dashboard untuk semua peran
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/buyer/dashboard', [DashboardController::class, 'buyerDashboard'])->name('buyer.dashboard');
    Route::get('/seller/dashboard', [DashboardController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->middleware('auth');
});

// Rute untuk Buyer
Route::prefix('buyer')->middleware(['auth', 'role:buyer'])->group(function () {
    // Manajemen tanah
    Route::get('/lands', [LandController::class, 'buyerIndex'])->name('buyer.lands.index');
    Route::get('/lands/{land}', [LandController::class, 'show'])->name('buyer.lands.show');
    Route::get('/buyer/lands/favorites', [LandController::class, 'favorites'])->name('buyer.lands.favorites');
    Route::post('/lands/{land}/favorite', [LandController::class, 'toggleFavorite'])->name('buyer.lands.toggleFavorite');

    // Manajemen transaksi
    Route::prefix('transactions')->group(function () {
        Route::get('/', [BuyerTransactionController::class, 'index'])->name('buyer.transactions.index');
        Route::get('/{land}/create', [BuyerTransactionController::class, 'create'])->name('buyer.transactions.create');
        Route::post('/{land}/store', [BuyerTransactionController::class, 'store'])->name('buyer.transactions.store');
        Route::get('/{transaction}', [BuyerTransactionController::class, 'show'])->name('buyer.transactions.show');
        Route::get('/{transaction}/download', [BuyerTransactionController::class, 'downloadCertificate'])->name('buyer.transactions.download');
    });
});

// Rute untuk Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Manajemen tanah
    Route::get('/lands', [LandController::class, 'adminIndex'])->name('admin.lands.index');
    Route::get('/lands/{land}', [LandController::class, 'showAdmin'])->name('admin.lands.show');
    Route::patch('/lands/{land}/verify', [LandController::class, 'verify'])->name('admin.lands.verify');
    Route::delete('/lands/{land}/reject', [LandController::class, 'reject'])->name('admin.lands.reject');

    // Manajemen pengguna
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Manajemen transaksi
    Route::prefix('transactions')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('admin.transactions.show');
    });
});

// Rute untuk Seller
Route::prefix('seller')->middleware(['auth', 'role:seller'])->group(function () {
    // Manajemen tanah
    Route::get('/lands', [LandController::class, 'sellerIndex'])->name('seller.lands.index');
    Route::get('/lands/create', [LandController::class, 'create'])->name('seller.lands.create');
    Route::post('/lands', [LandController::class, 'store'])->name('seller.lands.store');
    Route::get('/lands/{land}/edit', [LandController::class, 'edit'])->name('seller.lands.edit');
    Route::put('/lands/{land}', [LandController::class, 'update'])->name('seller.lands.update');
    Route::delete('/lands/{land}', [LandController::class, 'destroy'])->name('seller.lands.destroy');
    Route::post('/check-certificate', [LandController::class, 'checkCertificate'])->name('check.certificate');

    // Manajemen transaksi
    Route::prefix('transactions')->group(function () {
        Route::get('/', [SellerTransactionController::class, 'index'])->name('seller.transactions.index');
        Route::get('/{transaction}', [SellerTransactionController::class, 'show'])->name('seller.transactions.show');
        Route::post('/{transaction}/verify', [SellerTransactionController::class, 'verify'])->name('seller.transactions.verify');
        Route::patch('/{transaction}/reject', [SellerTransactionController::class, 'reject'])->name('seller.transactions.reject');
    });
});