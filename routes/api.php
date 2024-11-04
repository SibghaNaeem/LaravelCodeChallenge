<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('jokes', [ApiController::class, 'jokes'])->middleware('auth:sanctum')->name('jokes');
