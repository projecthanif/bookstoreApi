<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\PublisherController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\GenreController;
use App\Http\Controllers\Api\V1\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/login', [UserController::class, 'login']);
    Route::middleware(['auth:sanctum'])->controller('App\Http\Controllers\Api\V1')->group(function () {
        Route::apiResource('user', UserController::class)->except('post');
        Route::apiResource('publisher', PublisherController::class);
        Route::apiResource('author', AuthorController::class);
        Route::apiResource('book', BookController::class);
        Route::apiResource('genre', GenreController::class);
        Route::apiResource('cart', CartController::class);
    });
    Route::get('/genre/{id}/books', [GenreController::class, 'books']);
    Route::post('user', [UserController::class, 'store']);
});

