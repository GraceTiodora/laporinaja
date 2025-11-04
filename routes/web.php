<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;

// Homepage Route
Route::get('/', function () {
    return view('homepage');
});
