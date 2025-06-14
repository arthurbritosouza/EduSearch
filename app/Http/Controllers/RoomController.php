<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Relation;
use App\Models\User;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('room.index_room');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'password' => 'required',
        ]);

        $password = bcrypt($request->password);

        Room::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'password' => $password,
        ]);

        return redirect()->route('room.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('room.room', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function relationRoom(Request $request)
    {
        $parter_id = User::where('email', $request->email)->value('id');
        $owner_id = Room::where('id', $request->room_id)->value('user_id');

        if (!$parter_id) {
            return redirect()->back()->withError("O usuário com o email {$request->email} não foi encontrado.");
        }

        Relation::create([
            'user_id' => auth()->user()->id,
            'room_id' => $request->room_id,
            'owner_id' => $owner_id,
            'partner_id' => $parter_id
        ]);

        return redirect()->route('room.index')->withSuccess("Você foi adicionado à sala {$request->room_id} com sucesso.");

    }
}
