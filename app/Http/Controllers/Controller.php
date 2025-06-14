<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Topic_folder;
use App\Models\Note;
use App\Models\Room;
use App\Models\Relation;
use App\Models\Relation_notification;
use App\Models\User;
use App\Api;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
   public function relation_notify(Request $request)
{
    $parter_id = User::where('email', $request->email)->value('id');
    $owner_id = Room::where('id', $request->room_id)->value('user_id');
    if (!$parter_id) {
        return redirect()->back()->withError("O usuário com o email {$request->email} não foi encontrado.");
    }

    $relacione = Relation_notification::create([
        'user_id' => auth()->user()->id,
        'data_id' => $request->room_id,
        'partner_id' => $parter_id,
        'type' => 2
    ]);



    return redirect()->route('room.show', $request->room_id)->withSuccess("Soliciataçõ de amizade enviadas com sucesso.");

}
}


