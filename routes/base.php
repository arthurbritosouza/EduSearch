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
use App\Models\Relation_notification;
use App\Models\Relation;
use App\Models\Note;
use App\Models\User;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pdf_folder;
use App\Models\Relation_room;


Route::get('home', function () {
    $user = User::find(Auth::user()->id);
    $topics = Topic_folder::where('user_id', Auth::user()->id)->orderBy('id', 'desc')
    ->get();
    $pdfs = Pdf_folder::where('user_id', Auth::user()->id)->get();

    $relacionados = Topic_folder::join('relations', 'topic_folders.id', '=', 'relations.topic_id')
    ->where('relations.partner_id', Auth::user()->id)
    ->select('topic_folders.*')
    ->get();

    $rooms = Relation_room::where('partner_id', Auth::user()->id)->get();

    return view('home',compact('topics','relacionados','user','pdfs','rooms'));

})->name('home');

Route::get('notifications',function(){
    $notifications = Relation_notification::join('users', 'relation_notifications.user_id', '=', 'users.id')
    ->join('rooms', 'relation_notifications.data_id', '=', 'rooms.id')
    ->where('relation_notifications.partner_id', auth()->user()->id)
    ->select('relation_notifications.*', 'users.name as name_user', 'rooms.name as name_relation')
    ->orderBy('created_at', 'desc')
    ->get();

    // dd($notifications);

    return view('notifications',compact('notifications'));


})->name('notifications');

Route::get('logout', [LoginController::class, 'logout']);
Route::get('relation_notification/{room_id}', [Controller::class, 'relation_notification'])->name('relation_notification');
Route::post('create_notification', [Controller::class, 'create_notification'])->name('create_notification');
