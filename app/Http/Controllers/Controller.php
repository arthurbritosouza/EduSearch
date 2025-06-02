<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Topic_folder;
use App\Models\Note;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\User;
use App\Api;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    private function createExercise($topic_id, $item,$level): Exercise
    {
        return Exercise::create([
            'user_id' => Auth::id(),
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
        $response = Http::timeout(120)->get(Api::endpoint().'/exercise_generator/'.$request->get('topic').'/'.$request->get('level').'/'.(int)$request->get('quantidade'));
        if ($response->successful()) {
            $responseData = $response->json();
            foreach ($responseData as $item) {
                $this->createExercise($data['id_topic'], $item, $data['level']);
            }
        }

        return redirect()->back()->withSuccess('Exercícios gerados com sucesso.');
    }

    private function createRelacione($topic_id, $owner_id, $partner_id): Relation
    {
        return Relation::create([
            'user_id' => Auth::id(),
            'topic_id' => $topic_id,
            'owner_id' => $owner_id,
            'partner_id' => $partner_id
        ]);
    }

    public function relations(Request $request)
    {
        $data = $request->all();
        if(empty($data['email'])){
            return redirect()->back()->withErrors('Email do parceiro não pode ser vazio.');
        }

        $parceiro = User::where('email', $data['email'])->first();
        if($parceiro == null){
            return redirect()->back()->withErrors('Email do parceiro não encontrado.');
        }
        $id_parceiro = $parceiro->id;
        $id_dono = Topic_folder::where('id', $data['id_topic'])->first()->user_id;
        $this->createRelacione($data['id_topic'], $id_dono, $id_parceiro);

        return redirect()->back()->withSuccess('Parceria criada com sucesso.');
    }

    public function add_anotacao(Request $request)
    {
        Note::create([
            'user_id' => Auth::id(),
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'annotation' => $request->annotation,
        ]);
        return redirect()->back()->withSuccess('Anotação criada com sucesso.');
    }

}


