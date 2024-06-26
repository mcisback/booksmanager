<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::get('books', [BookController::class, 'index'])->name('api.books.index');

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('books', BookController::class)->except('index');

    Route::get('books/favorites', [BookController::class, 'getFavorites'])->name('books.favorites');

    Route::get('books/{book}/favorites', [BookController::class, 'addToFavorites'])->name('books.favorites.add');
});

Route::name('api.')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});
