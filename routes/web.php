<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserContrller;
use App\Http\Controllers\groupController;
use App\Http\Controllers\stockController;
use App\Http\Controllers\productController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\CategoryController;
use \App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\locationsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|category.st
*/

Route::middleware(["auth", "admin"])->get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(["auth", "admin"])->prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});
Route::middleware(["auth", "admin"])->prefix('groupCategory')->group(function () {

    Route::get('/', [groupController::class, 'index'])->name('groupCategory.index');
    Route::post('/store', [groupController::class, 'store'])->name('groupCategory.store');
    Route::get('/edit/{id}', [groupController::class, 'edit'])->name('groupCategory.edit');
    Route::post('/update/{id}', [groupController::class, 'update'])->name('groupCategory.update');
    Route::post('/destroy/{id}', [groupController::class, 'destroy'])->name('groupCategory.destroy');
});
Route::middleware(["auth", "admin"])->prefix('products')->group(function () {
    Route::get('/', [productController::class, 'index'])->name('products.index');
    Route::post('/store', [productController::class, 'store'])->name('products.store');
    Route::get('/edit/{id}', [productController::class, 'edit'])->name('products.edit');
    Route::post('/update/{id}', [productController::class, 'update'])->name('products.update');
    Route::post('/destroy/{id}', [productController::class, 'destroy'])->name('products.destroy');
});
// middleware(["auth","admin"])->prefix('Supplier')->group(function () {
Route::middleware(["auth", "admin"])->prefix('Supplier')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('/destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});
Route::get('/stocks', [stockController::class, 'index'])->name('stocks.index');
Route::post('/stocks/store', [stockController::class, 'store'])->name('stocks.store');

Route::middleware(["auth", "admin"])->prefix('user')->group(function () {
    Route::get('/', [UserContrller::class, 'index'])->name('user.index');
    Route::post('/store', [UserContrller::class, 'store'])->name('user.store');
    Route::get('/edit/{id}', [UserContrller::class, 'edit'])->name('user.edit');
    Route::post('/update/{id}', [UserContrller::class, 'update'])->name('user.update');
    Route::post('/destroy/{id}', [UserContrller::class, 'destroy'])->name('user.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('location')->group(function () {
    Route::get('/', [locationsController::class, 'index'])->name('location.index');
    Route::post('/store', [locationsController::class, 'store'])->name('location.store');
    Route::get('/edit/{id}', [locationsController::class, 'edit'])->name('location.edit');
    Route::post('/update/{id}', [locationsController::class, 'update'])->name('location.update');
    Route::post('/destroy/{id}', [locationsController::class, 'destroy'])->name('location.destroy');
});
Route::middleware('auth')->prefix('profile')->group(function () {
// Route::get('/',[ProfilesController::class, 'index'])->name('profile.index');
Route::get('/',[ProfilesController::class, 'edit'])->name('profile.edit');
Route::post('/update/{id}',[ProfilesController::class, 'update'])->name('profile.update');

});
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit']);
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
