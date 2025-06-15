<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get("/login", function () {
    return view('login');
})->name('login')->middleware('guest');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login_form',[LoginController::class,'login_form'])->name('login_form')->middleware('guest');
Route::post('/register_user_form',[LoginController::class,'register_user_form'])->name('register_user_form')->middleware('guest');
