<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;

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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::resource('admin/categories', CategoryController::class);
    Route::resource('admin/brands', BrandController::class);
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::get('/profile/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
});
