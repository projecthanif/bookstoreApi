<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CreateNewUserController;
use App\Http\Controllers\Api\V1\GenreController;
use App\Http\Controllers\Api\V1\LoginUserController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PublisherController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WishListController;
use Illuminate\Support\Facades\Route;


Route::post('/login', LoginUserController::class);
Route::post('/user', CreateNewUserController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/users', UserController::class)->except('store');
    /**
     * @route('userBooks') get all book from current user
     */
    Route::get('/userBooks', [UserController::class, 'userBook']);

    Route::apiResource('publisher', PublisherController::class);

    Route::apiResource('author', AuthorController::class);
    Route::get('/author/{name}/books', [AuthorController::class, 'books']);

    Route::apiResource('book', BookController::class);

    Route::get('/genre/{id}/books', [GenreController::class, 'books']);
    Route::apiResource('genre', GenreController::class);

    Route::apiResource('/wishlist', WishListController::class)->except('show');

    Route::apiResource('/cart', CartController::class);
    Route::apiResource('/review', ReviewController::class);

    Route::apiResource('/order', OrderController::class);
});
