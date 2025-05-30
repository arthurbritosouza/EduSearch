<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Note;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\User;


class TopicController extends Controller
{
    private $apiEndpoint;
    
    public function __construct()
    {
        $this->apiEndpoint = env('API_ENDPOINT'); 
    }

    public function index()
    {
        //
    }
    public function create()
    {
        //
    }

    private function createMaterial($topic_id,$content,$level,$topico): Material
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

    private function createTopic($topic,$matter,$summary,$about,$topics): Topic_folder
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
        $request_api = Http::timeout(120)->get($this->apiEndpoint.'/new_topic_folder/'.$topic);

        if ($request_api->failed()) {
            return redirect()->back()->withErrors('Falha ao obter dados da API.');
        }

        $topicFolder = $this->createTopic($topic,$request_api[0],$request_api[1],$request_api[2],$request_api[3]);
        $topic_id = $topicFolder->id;  

        foreach ($request_api[4] as $material) {
            foreach ($material as $level => $content) {
                $this->createMaterial($topic_id, $content, $level, $topic);
            }
        }
        return redirect()->route('home');

    }

    public function show(Topic_folder $topic) 
    {
        $data_topic = Topic_folder::leftJoin('relations', 'topic_folders.id', '=', 'relations.topic_id')
        ->where('topic_folders.id',$id)
        ->where(function($query) {
            $query->where('topic_folders.user_id', Auth::user()->id)
                        ->orWhere('relations.owner_id', Auth::user()->id)
                        ->orWhere('relations.partner_id', Auth::user()->id);
        })
        ->select('topic_folders.*') 
        ->distinct()
        ->first();
        
        $exercises = Exercise::leftJoin('relations','exercises.topic_id','=','relations.topic_id')
        ->where('exercises.topic_id',$id)
        ->where(function($query) {
            $query->where('exercises.user_id', Auth::user()->id)
                        ->orWhere('relations.owner_id', Auth::user()->id)
                        ->orWhere('relations.partner_id', Auth::user()->id);
        })
        ->select('exercises.*')
        ->distinct()
        ->get();

        $materials = Material::leftJoin('relations','materials.topic_id','=','relations.topic_id')
        ->where('materials.topic_id',$id)
        ->where(function($query) {
            $query->where('materials.user_id', Auth::user()->id)
                    ->orWhere('relations.owner_id', Auth::user()->id)
                    ->orWhere('relations.partner_id', Auth::user()->id);
        })
        ->select('materials.*')
        ->distinct()
        ->get();        

        $anotacoes = Note::leftJoin('relations','notes.topic_id','=','relations.topic_id')
        ->where('notes.topic_id',$id)
        ->where(function($query) {
            $query->where('notes.user_id', Auth::user()->id)
                    ->orWhere('relations.owner_id', Auth::user()->id)
                    ->orWhere('relations.partner_id', Auth::user()->id);
        })
        ->select('notes.*')
        ->distinct()
        ->get();
        
        $parceiros = Relation::join('users', 'relations.partner_id', '=', 'users.id')
        ->where('relations.topic_id', $id)
        ->select('users.*')
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

        return view('topics.topico', ['texto' => $textoFormatado,'data_topic' => $data_topic,'arrayEx' => $arrayEx,'materials' => $materials,'topicFormatado' => $topicFormatado,'parceiros' => $parceiros,'anotacoes' => $anotacoes]);
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
            'name' => 'required|max:20'
        ]);
        $topic->update($validate);
        return redirect()->back()->with('success', 'Tópico atualizado com sucesso!');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic_folder $topic)
    {
        $topic->delete();
        return redirect()->route('home')->with('success', 'Tópico excluído com sucesso!');
    }
}
