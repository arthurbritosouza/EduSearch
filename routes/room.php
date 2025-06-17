<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoomController;



Route::resource('room', RoomController::class);

Route::prefix('room')->group(function () {
    Route::post('createTopicRoom', [RoomController::class, 'createTopicRoom'])->name('room.createTopicRoom');
    Route::get('addTopic/{room_id}/{topic_id}', [RoomController::class, 'addTopic'])->name('room.addTopic');
    Route::post('createPdfRoom', [RoomController::class, 'createPdfRoom'])->name('room.createPdfRoom');
    Route::get('addPdf/{room_id}/{pdf_id}', [RoomController::class, 'addPdf'])->name('room.addPdf');

 });
