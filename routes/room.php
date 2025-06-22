<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoomController;



Route::resource('room', RoomController::class);

Route::prefix('room')->group(function () {
    Route::post('createTopicRoom', [RoomController::class, 'createTopicRoom'])->name('room.createTopicRoom');
    Route::get('addTopic/{room_id}/{topic_id}', [RoomController::class, 'addTopic'])->name('room.addTopic');
    Route::post('createPdfRoom', [RoomController::class, 'createPdfRoom'])->name('room.createPdfRoom');
    Route::get('addPdf/{room_id}/{pdf_id}', [RoomController::class, 'addPdf'])->name('room.addPdf');

    // Rotas para gerenciamento de membros
    Route::put('changeRole/{room_id}/{partner_id}', [RoomController::class, 'changeRole'])->name('room.changeRole');
    Route::delete('removeMember/{room_id}/{partner_id}', [RoomController::class, 'removeMember'])->name('room.removeMember');
    Route::delete('leaveRoom/{room_id}/{partner_id}', [RoomController::class, 'leaveRoom'])->name('room.leaveRoom');
});
