<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BorrowerController;

Route::prefix('borrowers')->group(function () {
    Route::get('/', [BorrowerController::class, 'index']);
    Route::post('/', [BorrowerController::class, 'store']);
    Route::get('/{id}', [BorrowerController::class, 'show']); 
});
