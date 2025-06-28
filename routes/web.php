<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MaterialController;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\Note;
use App\Models\User;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pdf_folder;


require base_path('routes/login.php');

// // Rota pública para Notebook LM
Route::get('/notebook-lmm', function () {
    $topics = Topic_folder::where('user_id', Auth::id())->get();
    $pdfs = Pdf_folder::where('user_id', Auth::id())->get();

    // dd($topics, $pdfs);
    return view('notebook-lm.notebook-lm_view', compact('topics', 'pdfs'));
});

Route::get('/notes', function () {
    return view('notes');
})->name('notes');

Route::middleware(['auth'])->group(function () {
    require base_path('routes/base.php');
    require base_path('routes/notebooklm.php');
    require base_path('routes/room.php');
    require base_path('routes/topic.php');
    require base_path('routes/material.php');
    require base_path('routes/profile.php');

    Route::resources([
        'pdf' => PdfController::class
    ]);
});

Route::get('/notes', function () {
    return view('notes');
})->name('notes');

