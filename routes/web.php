<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang');
Auth::routes();

Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('show');

Route::group(['middleware' => ['auth', 'user']], function () {
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
    Route::put('/update-cart', [CartController::class, 'updateCart'])->name('updateCart');
    Route::delete('/delete-cart', [CartController::class, 'deleteCart'])->name('deleteCart');
    Route::get('/count-product', [CartController::class, 'countProduct'])->name('countProduct');
    Route::post('/add-more-product/{id}', [CartController::class, 'addMoreProduct'])->name('addMoreProduct');
    Route::post('/add-quantity/{id}', [CartController::class, 'addMoreProduct'])->name('addQuantity');
    Route::resource('/carts', CartController::class);
    Route::get('/checkout', [OrderController::class, 'infoCheckout'])->name('checkout');
    Route::resource('orders', OrderController::class)->only(['store']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('/categories', CategoryController::class);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
    Route::resource('/brands', BrandController::class);
    Route::delete('/deleteimage/{id}', [ProductController::class, 'deleteimage'])->name('deleteimage');
    Route::resource('/products', ProductController::class);
    Route::get('/all-cancel-order', [OrderController::class, 'allCancelOrder'])->name('allCancelOrder');
    Route::get('/view-cancel-order/{id}', [OrderController::class, 'viewCancelOrder'])->name('viewCancelOrder');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'edit', 'update']);
});

Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'user']], function () {
    Route::put('/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::get('/password/{id}/edit', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password/{id}', [ChangePasswordController::class, 'change'])->name('password.change');
    Route::get('/orders/{id}', [UserController::class, 'viewOrders'])->name('viewOrders');
    Route::get('/view-order/{id}', [UserController::class, 'viewDetailOrder'])->name('viewDetailOrder');
    Route::get('/view-status-order/{idUser}/{idStatus}', [UserController::class, 'viewStatusOrder'])->name('viewStatusOrder');
});
