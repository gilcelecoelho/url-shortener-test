<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShortUrlController::class, 'index'])->name('home');
Route::post('/shorten', [ShortUrlController::class, 'store'])->name('shorten');
Route::get('/{shortUrl}', [ShortUrlController::class, 'redirect'])->name('short.redirect');
