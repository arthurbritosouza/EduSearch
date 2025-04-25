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
    public function new_topic_folder(Request $request){
        $topico = $request->get('topico');
        $apiEndpoint = env('API_ENDPOINT');
        $request_api = Http::timeout(120)->get($apiEndpoint.'/new_topic_folder/'.$topico);
        if ($request_api->successful()){
            $materia_topico = $request_api[0];
            $resumo = $request_api[1];
            $sobre = $request_api[2];
            $topicos = $request_api[3];
            $materiais = $request_api[4];

            $t = new Topic_folder();
            $t->user_id = Auth::user()->id;
            $t->name = $topico;
            $t->materia = $materia_topico;
            $t->resumo = $resumo;
            $t->sobre = $sobre;
            $t->topics = $topicos;
            $t->save();

            $id_topic = $t->id;
            foreach ($materiais as $item) {
                foreach ($item as $level => $conteudo) {

                    $m = new Material();
                    $m->user_id = Auth::user()->id;
                    $m->id_topic = $id_topic;
                    $m->content_topic = $conteudo;
                    if($level == 'iniciante'){
                        $m->name_material = "Introdução de ".$topico." para iniciante";
                        $m->level = 1;
                    }elseif($level == 'intermediario'){
                        $m->name_material = "Material Intermediario de ".$topico;
                        $m->level = 2;
                    }elseif($level == 'avancado'){
                        $m->name_material = "Material de ".$topico." Avançado";
                        $m->level = 3;
                    }
                    $m->save();
                }
            }
            return redirect()->route('home');
        }
    }

    public function exercise_generator(Request $request){
        $level = $request->get('level');
        $id_topic = $request->get('id_topico');
        $quantidade = (int)$request->get('quantidade');
        $topic = $request->get('topico');
        $apiEndpoint = env('API_ENDPOINT');
        $response = Http::timeout(120)->get($apiEndpoint.'/exercise_generator/'.$topic.'/'.$level.'/'.$quantidade);
        $responseData = $response->json();
        foreach ($responseData as $item) {

            $e = new Exercises();
            $e->user_id = Auth::user()->id;
            $e->id_topic = $id_topic;
            $e->titulo = $item['titulo'];
            $e->alternativas = json_encode($item['alternativas']);
            $e->resolucao = $item['resolucao'];
            $e->correta = $item['correta'];
            $e->level = $level;
            $e->save();
        }
        return redirect()->back();
    }

    public function add_material(Request $request){
        $id_topic = $request->get('id_topico');
        $name_topico = $request->get('name_topico');
        $level = $request->get('nivel');
        $descricao = $request->get('descricao');
        $titulo = $request->get('titulo');
        $apiEndpoint = env('API_ENDPOINT');
        $content = Http::timeout(120)->get($apiEndpoint.'/add_material/'.$name_topico.'/'.$descricao.'/'.$level);

        #INCERT INTO Material (user_id, id_topic, name_material, content_topic, level) VALUES (1, 1, 'Introdução de PHP para iniciante', 'Conteúdo da Introdução de PHP para iniciante', 1);
        $m = new Material();
        $m->user_id = Auth::user()->id;
        $m->id_topic = $id_topic;
        $m->name_material = $titulo;
        $m->content_topic = $content[0];
        if($level == 'iniciante'){
            $m->level = 1;
        }elseif ($level == 'intermediario'){
            $m->level = 2;
        } elseif($level == 'avancado'){
            $m->level = 3;
        }
        $m->save();


        return redirect()->back();
    }

    public function delete_topic($id){
        Topic_folder::where('id', $id)->delete();
        Material::where('id_topic', $id)->delete();
        Exercises::where('id_topic', $id)->delete();

        return redirect()->route('home');
    }

    public function relacione(Request $request){
        $id_topic = $request->get('id_topico');
        $email_parceiro = $request->get('email');

        $id_parceiro = Users::where('email', $email_parceiro)->first()->id;
        $id_dono = Topic_folder::where('id', $id_topic)->first()->user_id;
        
        $r = new Relacione();
        $r->user_id = Auth::user()->id;
        $r->id_topico = $id_topic;
        $r->id_dono = $id_dono;
        $r->id_parceiro = $id_parceiro;
        $r->save();
        return redirect()->back();
    }

    public function add_anotacao(Request $request){
        $id_topic = $request->get('id_topic');
        $titulo = $request->get('titulo');
        $anotacao = $request->get('anotacao');

        $a = new Anotacao();
        $a->user_id = Auth::user()->id;
        $a->id_topic = $id_topic;
        $a->titulo = $titulo;
        $a->anotacao = $anotacao;
        $a->save();

        return redirect()->back();
    }

    public function delete_anotacao($id){
        Anotacao::where('id', $id)->delete();
        return redirect()->back();
    }


}


// SALVAR EM JSON E TESTAT NOVAMENTE ESSE CACETETETE
