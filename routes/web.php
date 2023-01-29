<?php

use App\Http\Controllers\NearbyOfficesController;
use Illuminate\Support\Facades\Route;

Route::resource('nearby-offices', NearbyOfficesController::class)
    ->except([
        'show', 'update', 'destroy', 'edit', 'create'
    ]);


Route::fallback(function () {
    return redirect('/nearby-offices');
});
