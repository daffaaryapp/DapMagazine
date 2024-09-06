<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ROUTES UNTUK URL HALAMAN WEB DEPAN

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/details/{article_news_slug}', [FrontController::class, 'details'])->name('front.details');

Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/author/{author:slug}', [FrontController::class, 'author'])->name('front.author');

Route::get('/search', [FrontController::class, 'search'])->name('front.search');

