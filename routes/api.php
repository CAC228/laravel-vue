<?php

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware('auth:api')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{id}', [ItemController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
});
