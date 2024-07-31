<?php

use App\Http\Controllers\Api\V1\{UserController, PublisherController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//
//
//{
//    "admin": "1|JahnHU5vBgjMCfKshfsOP1V02s7mfw4c1IgveLRI63a08ba7",
//  "normal": "2|4d8u9ueM3L6coZUY0J67AAPx867NlP0FjSNEigKX2eca28e2"
//}

Route::get('/setup', static function () {
    \App\Models\User::create([
        'email' => 'admin@admin.com',
        'name' => 'admin',
        'role' => 'superadmin',
        'password' => bcrypt('password')
    ]);
    \Illuminate\Support\Facades\Auth::attempt([
        'email' => 'admin@admin.com',
        'password' => 'password'
    ]);

    if (\Illuminate\Support\Facades\Auth::check()) {
        $user = \Illuminate\Support\Facades\Auth::user();

        $superToken = $user?->createToken('admin');
        $normal = $user?->createToken('normal', ['edit', 'delete']);

        return [
            'admin' => $superToken->plainTextToken,
            'normal' => $normal->plainTextToken,
        ];
    }

    return [];
});


Route::prefix('v1')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::apiResource('user', UserController::class)->except('post');
        Route::apiResource('publisher', PublisherController::class);
    });

    Route::post('user', [UserController::class, 'store']);
});
