<?php

use App\Http\Controllers\Admin\ResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/resources', [ResourceController::class, 'index']);
Route::get('/resources/download/{id}', [ResourceController::class, 'download']);
Route::post('/resources/update/{id}', [ResourceController::class, 'update']);
Route::post('/resources/destroy/{id}', [ResourceController::class, 'destroy']);
Route::post('/resources', [ResourceController::class, 'store']);
