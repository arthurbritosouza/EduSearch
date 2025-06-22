<?php

namespace App\Http\Controllers;

use App\Models\Pdf_folder;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Relation;
use App\Models\Topic_folder;
use App\Models\Relation_room;
use App\Models\Room_content;
use App\Models\User;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Log;


class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::join('relation_rooms', 'rooms.id', '=', 'relation_rooms.room_id')
            ->where(function ($query) {
                $query->where('relation_rooms.partner_id', auth()->user()->id)
                    ->orWhere('rooms.user_id', auth()->user()->id);
            })
            ->select('rooms.*')
            ->orderBy('rooms.id', 'desc')
            ->distinct()
            ->get();

        $roomIds = $rooms->pluck('id')->toArray();

        $participants = Relation_room::join('users', 'relation_rooms.partner_id', '=', 'users.id')
            ->whereIn('relation_rooms.room_id', $roomIds)
            ->select('relation_rooms.*', 'users.name', 'users.email', 'users.id as user_id')
            ->get();

        $participantsByRoom = $participants->groupBy('room_id');

        // dd($roomIds, $participants, $participantsByRoom);
        return view('room.index_room', compact('rooms', 'participants', 'participantsByRoom'));
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
        $password = bcrypt($request->password);

        Room::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'password' => $password,
        ]);

        Relation_room::create([
            'user_id' => auth()->user()->id,
            'room_id' => Room::latest()->first()->id,
            'owner_id' => auth()->user()->id,
            'partner_id' => auth()->user()->id,
            'role' => 1
        ]);
        return redirect()->route('room.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $participants = Relation_room::join('users', 'relation_rooms.partner_id', '=', 'users.id')
            ->where('relation_rooms.room_id', $room->id)
            ->select('relation_rooms.*', 'users.name', 'users.email', 'users.id as userId')
            ->get();
        // dd($participants);

        $topics = Topic_folder::where('user_id', auth()->user()->id)->get();
        $pdfs = Pdf_folder::where('user_id', auth()->user()->id)->get();

        $related_topics = Room_content::join('topic_folders', 'room_contents.content_id', '=', 'topic_folders.id')
            ->join('users', 'topic_folders.user_id', '=', 'users.id')
            ->where('room_contents.room_id', $room->id)
            ->where('room_contents.content_type', 1)
            ->select('topic_folders.*', 'users.name as user_name')
            ->get();

        $related_pdfs = Room_content::join('pdf_folders', 'room_contents.content_id', '=', 'pdf_folders.id')
            ->join('users', 'pdf_folders.user_id', '=', 'users.id')
            ->where('room_contents.room_id', $room->id)
            ->where('room_contents.content_type', 2)
            ->select('pdf_folders.*', 'users.name as user_name')
            ->get();

        $roleAuthUser = Relation_room::where('room_id', $room->id)->where('partner_id', auth()->user()->id)->value('role');
        // dd(auth()->user()->name, $roleAuthUser);

        return view('room.room_view', compact('room', 'participants', 'topics', 'pdfs', 'related_topics', 'related_pdfs', 'roleAuthUser'));
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
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $room->update($request->all());
        return redirect()->route('room.show', $room->id)->with('success', 'Sala atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // Verificar se o usuário tem permissão para excluir a sala (apenas administrador - role 1)
        $userRole = Relation_room::where('room_id', $room->id)
            ->where('partner_id', auth()->user()->id)
            ->value('role');

        if ($userRole != 1) {
            return redirect()->back()->withError('Você não tem permissão para excluir esta sala.');
        }

        // Verificar se o usuário é o criador da sala
        if ($room->user_id != auth()->user()->id) {
            return redirect()->back()->withError('Apenas o criador da sala pode excluí-la.');
        }

        $room->delete();
        return redirect()->route('room.index')->withSuccess('Sala excluída com sucesso.');
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

    public function createTopicRoom(Request $request)
    {
        app(TopicController::class)->store($request);
        $topic_id = Topic_folder::latest('id')->first()->id;

        Room_content::create([
            'user_id' => auth()->user()->id,
            'room_id' => $request->room_id,
            'content_id' => $topic_id,
            'content_type' => 1
        ]);

        return redirect()->route('room.show', ['room' => $request->room_id])->withSuccess('Tópico criado com sucesso.');
    }

    public function addTopic($room_id, $topic_id)
    {
        if (Topic_folder::where('id', $topic_id)->doesntExist()) {
            return redirect()->back()->withError('Tópico não encontrado.');
        }

        if (Topic_folder::where('id', $topic_id)->where('user_id', auth()->user()->id)->exists()) {
            Room_content::create([
                'user_id' => auth()->user()->id,
                'room_id' => $room_id,
                'content_id' => $topic_id,
                'content_type' => 1
            ]);
            return redirect()->route('room.show', ['room' => $room_id])->withSuccess('Tópico adicionado à sala com sucesso.');
        }
    }

    public function createPdfRoom(Request $request)
    {
        app(PdfController::class)->store($request);
        $pdf_id = Pdf_folder::latest('id')->first()->id;

        Room_content::create([
            'user_id' => auth()->user()->id,
            'room_id' => $request->room_id,
            'content_id' => $pdf_id,
            'content_type' => 2
        ]);
        return redirect()->route('room.show', ['room' => $request->room_id])->withSuccess('Pdf criado com sucesso.');
    }

    public function addPdf($room_id, $pdf_id)
    {
        if (Pdf_folder::where('id', $pdf_id)->doesntExist()) {
            return redirect()->back()->withError('PDF não encontrado.');
        }

        if (Pdf_folder::where('id', $pdf_id)->where('user_id', auth()->user()->id)->exists()) {
            Room_content::create([
                'user_id' => auth()->user()->id,
                'room_id' => $room_id,
                'content_id' => $pdf_id,
                'content_type' => 2
            ]);
            return redirect()->route('room.show', ['room' => $room_id])->withSuccess('PDF adicionado à sala com sucesso.');
        }
    }

    public function changeRole(Request $request, $room_id, $parter_id)
    {

        $userRole = Relation_room::where('room_id', $room_id)
            ->where('partner_id', auth()->user()->id)
            ->value('role');

        if ($userRole != 1 && $userRole != 2) {
            return redirect()->back()->withError('Você não tem permissão para alterar cargos.');
        }

        Relation_room::where('room_id', $room_id)
            ->where('partner_id', $parter_id)
            ->update(['role' => $request->role]);

        return redirect()->back()->withSuccess('Cargo alterado com sucesso.');
    }

    public function removeMember($room_id, $parter_id)
    {
        //   dd($room_id, $parter_id);
        $userRole = Relation_room::where('room_id', $room_id)
            ->where('partner_id', auth()->user()->id)
            ->value('role');


        if ($userRole != 1 && $userRole != 2) {
            return redirect()->back()->withError('Você não tem permissão para remover membros.');
        }

        Relation_room::where('room_id', $room_id)
            ->where('partner_id', $parter_id)
            ->delete();

        return redirect()->back()->withSuccess('Membro removido com sucesso.');
    }

    public function leaveRoom($room_id, $partner_id)
    {
        if ($partner_id != auth()->user()->id) {
            return redirect()->back()->withError('Você só pode sair da sua própria conta.');
        }

        // Verificar se o usuário é membro da sala
        $relation = Relation_room::where('room_id', $room_id)
            ->where('partner_id', $partner_id)
            ->first();

        if (!$relation) {
            return redirect()->back()->withError('Você não é membro desta sala.');
        }

        $room = Room::find($room_id);
        if ($room->user_id == $partner_id) {
            return redirect()->back()->withError('O criador da sala não pode sair. Transfira a propriedade ou exclua a sala.');
        }

        try {
            // Remover o relacionamento do usuário com a sala
            $relation->delete();

            return redirect()->route('room.index')->withSuccess('Você saiu da sala com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Erro ao sair da sala. Tente novamente.');
        }
    }
}
