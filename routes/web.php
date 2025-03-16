<?php

use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/services/{slug}', [FrontendController::class, 'service'])->name('service');
Route::get('/page/{slug}', [FrontendController::class, 'page'])->name('page');

// Include admin routes
require __DIR__.'/admin.php';
