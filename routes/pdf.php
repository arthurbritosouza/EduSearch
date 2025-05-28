<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\Note;
use App\Models\User;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::resource('/pdf', PdfController::class);



// Route::get('/pdf_view/{id_pdf}', function ($id_pdf) {
//         return view('pdf_views/pdf');
// })->name('pdf_view');

// Route::post('/upload_pdfs', [PdfController::class, 'uploadPdfs'])->name('upload.pdfs');
