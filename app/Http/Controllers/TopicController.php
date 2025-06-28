<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Topic_folder;
use App\Models\Room_content;
use App\Models\Relation_room;
use App\Models\Material;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\Note;
use App\Models\User;
use App\Api;
use Illuminate\Support\Facades\Cookie;
use App\NotifyDiscord;
use App\Models\Room;

class TopicController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $folders = Topic_folder::where('user_id', auth()->user()->id)->orderBy('id', 'desc')
            ->get();

        $relacionados = Topic_folder::join('relations', 'topic_folders.id', '=', 'relations.topic_id')
            ->where('relations.partner_id', auth()->user()->id)
            ->select('topic_folders.*')
            ->get();

        return view('topics.index_topics', compact('folders', 'user', 'relacionados'));
    }

    public function create()
    {
        //
    }

    private function createMaterial($topic_id, $content, $level, $topico): Material
    {
        $levelMap = [
            'iniciante' => ['Introdução de ', 1],
            'intermediario' => ['Material Intermediario de ', 2],
            'avancado' => ['Material de ', 3]
        ];

        return Material::create([
            'user_id' => auth()->user()->id,
            'topic_id' => $topic_id,
            'content_topic' => $content,
            'name_material' => $levelMap[$level][0] . $topico . ($level === 'avancado' ? ' Avançado' : ''),
            'level' => $levelMap[$level][1]
        ]);
    }

    private function createTopic($topic, $matter, $summary, $about, $topics): Topic_folder
    {
        return Topic_folder::create([
            'user_id' => auth()->user()->id,
            'name' => $topic,
            'matter' => $matter,
            'summary' => $summary,
            'about' => $about,
            'topics' => $topics
        ]);
    }

    public function store(Request $request)
    {
        $topic = $request->get('topic');
        $request_api = Http::timeout(120)->get(Api::endpoint() . '/new_topic_folder/' . $topic);

        if ($request_api->failed()) {
            return redirect()->back()->withErrors('Falha ao obter dados da API.');
        }

        $topicFolder = $this->createTopic($topic, $request_api[0], $request_api[1], $request_api[2], $request_api[3]);
        $topic_id = $topicFolder->id;

        NotifyDiscord::notify('topic', $topic, $topic_id);


        foreach ($request_api[4] as $material) {
            foreach ($material as $level => $content) {
                $this->createMaterial($topic_id, $content, $level, $topic);
            }
        }
        return redirect()->route('topic.index')->withSucess('Tópico criado com sucesso!');
    }

    public function show(Topic_folder $topic)
    {
        $data_topic = Topic_folder::leftJoin('relations', 'topic_folders.id', '=', 'relations.topic_id')
            ->leftJoin('room_contents', function ($join) {
                $join->on('topic_folders.id', '=', 'room_contents.content_id')
                    ->where('room_contents.content_type', 1);
            })
            ->leftJoin('relation_rooms', 'room_contents.room_id', '=', 'relation_rooms.room_id')
            ->where('topic_folders.id', $topic->id)
            ->where(function ($query) {
                $query->where('topic_folders.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id)
                    ->orWhere('relation_rooms.partner_id', auth()->user()->id);
            })
            ->select('topic_folders.*')
            ->distinct()
            ->first();

        $exercises = Exercise::leftJoin('relations', 'exercises.topic_id', '=', 'relations.topic_id')
            ->leftJoin('room_contents', function ($join) {
                $join->on('exercises.topic_id', '=', 'room_contents.content_id')
                    ->where('room_contents.content_type', 1);
            })
            ->leftJoin('relation_rooms', 'room_contents.room_id', '=', 'relation_rooms.room_id')
            ->where('exercises.topic_id', $topic->id)
            ->where(function ($query) {
                $query->where('exercises.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id)
                    ->orWhere('relation_rooms.partner_id', auth()->user()->id);
            })
            ->select('exercises.*')
            ->distinct()
            ->get();
        // dd($exercises);

        $materials = Material::leftJoin('relations', 'materials.topic_id', '=', 'relations.topic_id')
            ->leftJoin('room_contents', function ($join) {
                $join->on('materials.topic_id', '=', 'room_contents.content_id')
                    ->where('room_contents.content_type', 1);
            })
            ->leftJoin('relation_rooms', 'room_contents.room_id', '=', 'relation_rooms.room_id')
            ->where('materials.topic_id', $topic->id)
            ->where(function ($query) {
                $query->where('materials.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id)
                    ->orWhere('relation_rooms.partner_id', auth()->user()->id)
                    ->orWhere('relation_rooms.partner_id', auth()->user()->id);
            })
            ->select('materials.*')
            ->distinct()
            ->get();

        $anotacoes = Note::leftJoin('relations', 'notes.topic_id', '=', 'relations.topic_id')
            ->leftJoin('room_contents', function ($join) {
                $join->on('notes.topic_id', '=', 'room_contents.content_id')
                    ->where('room_contents.content_type', 1);
            })
            ->leftJoin('relation_rooms', 'room_contents.room_id', '=', 'relation_rooms.room_id')
            ->where('notes.topic_id', $topic->id)
            ->where(function ($query) {
                $query->where('notes.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id)
                    ->orWhere('relation_rooms.partner_id', auth()->user()->id);
            })
            ->select('notes.*')
            ->distinct()
            ->get();
        // dD($anotacoes);

        $parceiros = Relation::join('users', 'relations.partner_id', '=', 'users.id')
            ->where('relations.topic_id', $topic->id)
            ->select('users.*')
            ->distinct()
            ->get();

        $rooms = Room_content::join('rooms', 'room_contents.room_id', '=', 'rooms.id')
            ->where('room_contents.content_id', $topic->id)
            ->where('room_contents.content_type', 1)
            ->select('rooms.*')
            ->distinct()
            ->get();
        // dd($rooms);

        // Buscar salas do usuário para o modal
        $userRooms = Room::join('relation_rooms', 'rooms.id', '=', 'relation_rooms.room_id')
            ->where('relation_rooms.partner_id', auth()->user()->id)
            ->select('rooms.*')
            ->distinct()
            ->get();

        $arrayEx = [];
        foreach ($exercises as $exercise) {
            $arrayEx[] = [
                'id' => $exercise->id,
                'title' => $exercise->title,
                'level' => $exercise->level,
                'alternatives' => array_values(array_filter(json_decode($exercise->alternatives, true))),
                'resolution' => $exercise->resolution,
            ];
        }
        $converter = new CommonMarkConverter();
        $textoFormatado = $converter->convertToHtml($data_topic->about);
        $topicFormatado = $converter->convertToHtml($data_topic->topics);

        return view('topics.topic_view', ['texto' => $textoFormatado, 'data_topic' => $data_topic, 'arrayEx' => $arrayEx, 'materials' => $materials, 'topicFormatado' => $topicFormatado, 'parceiros' => $parceiros, 'anotacoes' => $anotacoes, 'rooms' => $rooms, 'userRooms' => $userRooms]);
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
    public function update(Request $request, Topic_folder $topic)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);
        $topic->update($validate);
        return redirect()->back()->withSuccess('Tópico atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic_folder $topic)
    {
        if ($topic->user_id !== auth()->user()->id) {
            return redirect()->back()->withErrors('Você não tem permissão para excluir este tópico.');
        }

        $topic->delete();
        return redirect()->route('home')->withSuccess('Tópico excluído com sucesso!');
    }

    public function addAnnotation(Request $request)
    {
        Note::create([
            'user_id' => auth()->user()->id,
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'annotation' => $request->annotation,
        ]);

        return redirect()->back()->withSuccess('Anotação criada com sucesso.');
    }

    public function deleteAnnotation(Note $note)
    {
        if ($note->user_id !== auth()->user()->id) {
            return redirect()->back()->withErrors('Você não tem permissão para excluir esta anotação.');
        }

        $note->delete();
        return redirect()->back()->withSuccess('Anotação excluída com sucesso.');
    }

    private function createExercise($topic_id, $item, $level): Exercise
    {
        return Exercise::create([
            'user_id' => auth()->user()->id,
            'topic_id' => $topic_id,
            'title' => $item['titulo'],
            'alternatives' => json_encode($item['alternativas']),
            'resolution' => $item['resolucao'],
            'correct' => $item['correta'],
            'level' => $level
        ]);
    }


    public function exercise_generator(Request $request)
    {
        $data = $request->all();
        $response = Http::timeout(120)->get(Api::endpoint() . '/exercise_generator/' . $request->get('topic') . '/' . $request->get('level') . '/' . (int)$request->get('quantidade'));
        if ($response->successful()) {
            $responseData = $response->json();
            foreach ($responseData as $item) {
                $exercise = $this->createExercise($data['id_topic'], $item, $data['level']);
                $exercise_id = $exercise->id;
                NotifyDiscord::notify('exercise', $data['level'], $exercise_id);
            }
        }

        return redirect()->back()->withSuccess('Exercícios gerados com sucesso.');
    }

    private function createRelacione($topic_id, $owner_id, $partner_id): Relation
    {
        return Relation::create([
            'user_id' => auth()->user()->id,
            'topic_id' => $topic_id,
            'owner_id' => $owner_id,
            'partner_id' => $partner_id
        ]);
    }

    public function relations(Request $request)
    {
        $data = $request->all();
        if (empty($data['email'])) {
            return redirect()->back()->withErrors('Email do parceiro não pode ser vazio.');
        }

        $parceiro = User::where('email', $data['email'])->first();
        if ($parceiro == null) {
            return redirect()->back()->withErrors('Email do parceiro não encontrado.');
        }
        $id_parceiro = $parceiro->id;
        $id_dono = Topic_folder::where('id', $data['id_topic'])->first()->user_id;
        $this->createRelacione($data['id_topic'], $id_dono, $id_parceiro);

        return redirect()->back()->withSuccess('Parceria criada com sucesso.');
    }
}
