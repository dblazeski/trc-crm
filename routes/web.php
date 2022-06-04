<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home-page');
Route::view('/admin', 'admin.dashboard-page');
