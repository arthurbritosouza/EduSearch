<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercises;
use App\Models\Relacione;
use App\Models\Anotacao;
use App\Models\Users;

use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    private $apiEndpoint; // Variável PRIVADA da classe
    
    public function __construct()
    {
        // Acesso PERMITIDO (dentro da classe)
        $this->apiEndpoint = env('API_ENDPOINT'); 
    }

    private function createMaterial($id_topic,$content,$level,$topico): Material
    {
        $levelMap = [
            'iniciante' => ['Introdução de ', 1],
            'intermediario' => ['Material Intermediario de ', 2],
            'avancado' => ['Material de ', 3]
        ];

        return Material::create([
            'user_id' => Auth::id(),
            'id_topic' => $id_topic,
            'content_topic' => $content,
            'name_material' => $levelMap[$level][0] . $topico . ($level === 'avancado' ? ' Avançado' : ''),
            'level' => $levelMap[$level][1]
        ]);
    }

    private function createTopic($request_api,$topic): Topic_folder
    {
        return Topic_folder::create([
            'user_id' => Auth::id(),
            'name' => $topic,
            'materia' => $request_api[0],
            'resumo' => $request_api[1],
            'sobre' => $request_api[2],
            'topics' => $request_api[3]
        ]);
    }

    public function new_topic_folder(Request $request)
    {
        $topic = $request->get('topic');
        $request_api = Http::timeout(120)->get($this->apiEndpoint.'/new_topic_folder/'.$topic);

        if ($request_api->failed()) {
            return redirect()->back()->withErrors('Falha ao obter dados da API.');
        }

        $topicFolder = $this->createTopic($request_api, $topic);
        $id_topic = $topicFolder->id;  

        foreach ($request_api[4] as $material) {
            foreach ($material as $level => $content) {
                $this->createMaterial($id_topic, $content, $level, $topic);
            }
        }
        return redirect()->route('home');

    }

    private function createExercise($id_topic, $item,$level): Exercises
    {
        return Exercises::create([
            'user_id' => Auth::id(),
            'id_topic' => $id_topic,
            'titulo' => $item['titulo'],
            'alternativas' => json_encode($item['alternativas']),
            'resolucao' => $item['resolucao'],
            'correta' => $item['correta'],
            'level' => $level
        ]);
    }

    public function exercise_generator(Request $request)
    {
        $data = $request->all();
        $response = Http::timeout(120)->get($this->apiEndpoint.'/exercise_generator/'.$request->get('topic').'/'.$request->get('level').'/'.(int)$request->get('quantidade'));
        if ($response->successful()) {
            $responseData = $response->json();
            foreach ($responseData as $item) {
                $this->createExercise($data['id_topic'], $item, $data['level']);
            }
        }

        return redirect()->back()->withSuccess('Exercícios gerados com sucesso.');
    }
    
    private function addMaterial($id_topic, $content, $level, $topic): Material
    {
        $levelMap = [
            'iniciante' => 1,
            'intermediario' => 2,
            'avancado' => 3
        ];

        return Material::create([
            'user_id' => Auth::id(),
            'id_topic' => $id_topic,
            'content_topic' => $content,
            'name_material' => $topic,
            'level' => $levelMap[$level]
        ]);
    }

    public function add_material(Request $request)
    {

        $data = $request->all();
        $content = Http::timeout(120)->get($this->apiEndpoint.'/add_material/'.$data['name_topic'].'/'.$data['descricao'].'/'.$data['level']);

        if ($content->successful()){
            $this->addMaterial($data['id_topic'], $content[0], $data['level'], $data['title']);
            return redirect()->back()->withSuccess('Material adicionado com sucesso.');
        } else{
            return redirect()->back()->withErrors('Erro ao cadastrar Material.');
        }
        
    }

    public function delete_topic($id)
    {
        try {
            $topic = Topic_folder::find($id);
            if (!$topic) {
                return redirect()->route('home')->withErrors('Tópico não encontrado.');
            }
            // Inicia uma transação
            \DB::beginTransaction();
    
            Material::where('id_topic', $id)->delete();
            Exercises::where('id_topic', $id)->delete();
    
            // Exclui o tópico
            $topic->delete();
    
            // Confirma a transação
            \DB::commit();
    
            return redirect()->route('home')->with('success', 'Tópico excluído com sucesso.');
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            \DB::rollBack();
    
            // Retorna com uma mensagem de erro
            return redirect()->route('home')->withErrors('Erro ao excluir o tópico: ' . $e->getMessage());
        }
    }

    private function createRelacione($id_topic, $id_dono, $id_parceiro): Relacione
    {
        return Relacione::create([
            'user_id' => Auth::id(),
            'id_topic' => $id_topic,
            'id_dono' => $id_dono,
            'id_parceiro' => $id_parceiro
        ]);
    }

    public function relacione(Request $request)
    {    
        $data = $request->all();
        if(empty($data['email'])){
            return redirect()->back()->withErrors('Email do parceiro não pode ser vazio.');
        }
        
        $parceiro = Users::where('email', $data['email'])->first();
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
        $id_topic = $request->get('id_topic');
        $titulo = $request->get('title');
        $anotacao = $request->get('anotacao');

        $a = new Anotacao();
        $a->user_id = Auth::user()->id;
        $a->id_topic = $id_topic;
        $a->titulo = $titulo;
        $a->anotacao = $anotacao;
        $a->save();

        return redirect()->back()->withSuccess('Anotação criada com sucesso.');
    }

    public function delete_anotacao($id){
        Anotacao::where('id', $id)->delete();
        return redirect()->back()->withErrors('Anotação excluída com sucesso.');
    }


}


// SALVAR EM JSON E TESTAT NOVAMENTE ESSE CACETETETE
