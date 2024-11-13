<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::apiResource('movies', MovieController::class);
