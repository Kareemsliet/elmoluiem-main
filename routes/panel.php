<?php

use App\Http\Controllers\Panel\CountriesController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "admin-panel"], function () {
    Route::resource("/countries", CountriesController::class);
});