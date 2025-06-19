<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::resource('profile', ProfileController::class);
