<?php

use App\Http\Controllers\Api\V1\{UserController, PublisherController, AuthorController};
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

    Route::post('/login', [UserController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::apiResource('user', UserController::class)->except('post');
        Route::apiResource('publisher', PublisherController::class);
        Route::apiResource('author', AuthorController::class);
    });

    Route::post('user', [UserController::class, 'store']);
});
