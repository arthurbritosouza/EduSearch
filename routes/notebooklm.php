<?php

use App\Http\Controllers\NotebookLmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Models\Topic_folder;
use App\Models\Pdf_folder;
use Illuminate\Support\Facades\Auth;


Route::resource('notebook-lm', NotebookLmController::class);
