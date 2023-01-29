<?php

use App\Http\Controllers\Api\NearbyOfficesController;
use App\Http\Controllers\Api\OfficeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('offices', OfficeController::class);

    Route::get('/nearby-offices', NearbyOfficesController::class)->name('nearby-offices');
});
