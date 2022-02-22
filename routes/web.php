<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
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

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::get('/lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang');
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('admin/brands', BrandController::class);

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
