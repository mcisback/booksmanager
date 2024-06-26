<?php

use App\Http\Controllers\ProfileController;
use App\Models\Book;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/books/{bookId}', function () {
    $book = Book::findOrFail(request('bookId'));

    return Inertia::render('Books/Book', [
        'book' => $book
    ]);
})->middleware(['auth', 'verified'])->name('bookById');

Route::get('/books', function () {
    return Inertia::render('Books/Favorites');
})->middleware(['auth', 'verified', 'role:user|admin'])->name('books.favorites');

Route::get('/dashboard/users', function () {
    return Inertia::render('Dashboard/Users');
})->middleware(['auth', 'verified', 'role:admin'])->name('dashboard.users');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
