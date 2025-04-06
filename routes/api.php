<?php

use App\Http\Controllers\CommentController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::post('/comments/{id}/rate', [CommentController::class, 'rateComment']);
});