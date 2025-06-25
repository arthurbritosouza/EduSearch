<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


Route::resource('login', LoginController::class)->middleware('guest');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login_form', [LoginController::class, 'login_form'])->name('login_form')->middleware('guest');
