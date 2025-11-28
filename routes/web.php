<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'index']);

