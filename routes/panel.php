<?php

use App\Http\Controllers\Api\Family\MainController;
use App\Http\Controllers\Panel\CountriesController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "admin-panel"], function () {
    Route::resource("/countries", CountriesController::class);

    Route::get("/",[MainController::class, "index"])->name("panel.index");
});

