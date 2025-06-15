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
   public function relation_notification($notify_id)
{
    $data_notifcation = Relation_notification::where('id', $notify_id)->first();
    $owner_id = Room::where('id', $data_notifcation->data_id)->value('user_id');

    // dd($data_notifcation,$owner_id);
    // dd($notify_id,$data_notifcation,$owner_id);
    Relation::create([
        'user_id' => $data_notifcation->user_id,
        'room_id' => $data_notifcation->data_id,
        'partner_id' => $data_notifcation->partner_id,
        'owner_id' => $owner_id,
    ]);

    Relation_notification::where('id', $notify_id)->delete();

    return redirect()->route('room.index', $notify_id)->withSuccess("Soliciataçõ de amizade aceita com sucesso.");

}

public function create_notification(Request $request){
    $parter_id = User::where('email',$request->email)->value('id');
    if(!$parter_id){
        return redirect()->back()->withError('Usuário não encontrado.');
    }
    Relation_notification::create([
        'user_id' => Auth::user()->id,
        'partner_id' => $parter_id,
        'data_id' => $request->room_id,
        'type' => 2
    ]);
    return redirect()->back()->withSuccess('Solicitação enviada com sucesso.');
}
}


