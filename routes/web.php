<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('books')->group(function () {
    // VIEW
    Route::get('/', [BookController::class, 'index'])->name('books.index');

    // ADD
    Route::get('/add', [BookController::class, 'add'])->name('books.add');
    Route::post('/store', [BookController::class, 'store'])->name('books.store');

    // UPDATE
    Route::get('edit/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{id}', [BookController::class, 'update'])->name('books.update');

    // DELETE
    Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy'); 
});
