<?php

use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskApiController::class, 'index']);
Route::post('/tasks', [TaskApiController::class, 'store']);