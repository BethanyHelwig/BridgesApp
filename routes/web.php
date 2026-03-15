<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;

Route::get('/', [StateController::class, 'index']);
Route::get('/getCountiesCities', [StateController::class, 'getCounties']);