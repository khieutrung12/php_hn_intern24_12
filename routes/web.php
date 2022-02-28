<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('/categories', CategoryController::class);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');
    Route::resource('/brands', BrandController::class);
    Route::delete('/deleteimage/{id}', [ProductController::class, 'deleteimage'])->name('deleteimage');
    Route::resource('/products', ProductController::class);
});

Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'user']], function () {
    Route::put('/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::get('/password/{id}/edit', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password/{id}', [ChangePasswordController::class, 'change'])->name('password.change');
});
