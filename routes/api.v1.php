<?php

use App\Http\Controllers\Api\V1\BooksController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Middleware\EnsureBookBelongsToAuthor;
use Illuminate\Support\Facades\Route;

Route::get('books', [BooksController::class, 'index']);
Route::get('books/{book}', [BooksController::class, 'show']);

Route::apiResource('authors', AuthorsController::class);

Route::prefix('authors/{author}')
    ->middleware(EnsureBookBelongsToAuthor::class)
    ->group(fn ($a) => Route::apiResource('books', BooksController::class));

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('404');
