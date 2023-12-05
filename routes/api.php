<?php

use App\Http\Controllers\Api\Auth\{LoginController, LogoutController, RegisterController};
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("auth")->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/register', RegisterController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
});

Route::apiResource("products", ProductController::class)->parameters([
    "products" => "product:slug"
]);
