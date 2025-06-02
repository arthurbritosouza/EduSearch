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
use App\Api;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function addMaterial($topic_id, $content, $level, $name): Material
    {
        $levelMap = [
            'iniciante' => 1,
            'intermediario' => 2,
            'avancado' => 3
        ];

        return Material::create([
            'user_id' => auth()->user()->id,
            'topic_id' => $topic_id,
            'content_topic' => $content,
            'name_material' => $name,
            'level' => $levelMap[$level]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('caiu');
        $data = $request->all();
        $content = Http::timeout(120)->get(Api::endpoint().'/add_material/'.$data['name_topic'].'/'.$data['descricao'].'/'.$data['level']);

        if ($content->successful()){
            $this->addMaterial($data['id_topic'], $content[0], $data['level'], $data['title']);
            return redirect()->back()->withSuccess('Material adicionado com sucesso.');
        } else{
            return redirect()->back()->withErrors('Erro ao cadastrar Material.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $data_material = Material::leftJoin('relations','materials.topic_id','=','relations.topic_id')
            ->where('materials.id', $material->id)
            ->where(function($query) {
                $query->where('materials.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id);
            })
            ->select('materials.*')
            ->distinct()
            ->first();

        $data_topic = Topic_folder::leftJoin('relations', 'topic_folders.id', '=', 'relations.topic_id')
            ->where('topic_folders.id', $material->topic_id)
            ->where(function($query) {
                $query->where('topic_folders.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id);
            })
            ->select('topic_folders.*')
            ->distinct()
            ->first();

        $exercises = Exercise::leftJoin('relations','exercises.topic_id','=','relations.topic_id')
            ->where('exercises.topic_id', $material->topic_id)
            ->where(function($query) {
                $query->where('exercises.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id);
            })
            ->select('exercises.*')
            ->get();

        $converter = new \League\CommonMark\CommonMarkConverter();
        $textoMD = $converter->convertToHtml($data_material->content_topic);

        return view('topics.material', [
            'textoMD' => $textoMD,
            'data_topic' => $data_topic,
            'exercises' => $exercises,
            'data_material' => $data_material
        ]);
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
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('topic.show', $material->topic_id)->with('success', 'Material eliminado correctamente');
    }
}
