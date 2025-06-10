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


Route::get('/home', function () {
    $user = User::find(Auth::user()->id);
    $folders = Topic_folder::where('user_id', Auth::user()->id)->orderBy('id', 'desc')
    ->get();
    $pdfs = Pdf_folder::where('user_id', Auth::user()->id)->get();

    $relacionados = Topic_folder::join('relations', 'topic_folders.id', '=', 'relations.topic_id')
    ->where('relations.partner_id', Auth::user()->id)
    ->select('topic_folders.*')
    ->get();

    // dd($folders);

    return view('home',compact('folders','relacionados','user','pdfs'));
})->name('home');

require base_path('routes/login.php');

Route::group(['middleware' => ['auth']], function () {
    Route::resources([
        'topic' => TopicController::class,
        'material' => MaterialController::class,
        'pdf' => PdfController::class,
        'room' => RoomController::class
    ]);
     require base_path('routes/topic.php');
});
