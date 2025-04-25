<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercises;
use App\Models\Relacione;
use App\Models\Anotacao;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => ['guest']], function () {

    Route::get("/login", function () {
        return view('login');
    })->name('login');
    
    Route::post('/login_form',[LoginController::class,'login_form'])->name('login_form');
    Route::post('/register_user_form',[LoginController::class,'register_user_form'])->name('register_user_form');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', function () {
        $folders = Topic_folder::where('user_id', Auth::user()->id)->get();

        $relacionados = Topic_folder::join('relacione', 'topic_folder.id', '=', 'relacione.id_topico')
        ->where('relacione.id_parceiro', Auth::user()->id)
        ->select('topic_folder.*') 
        ->get(); 

        return view('home',compact('folders','relacionados'));
    })->name('home');

    Route::get('/topico/{id}', function ($id) {
        $dados_topico = Topic_folder::leftJoin('relacione', 'topic_folder.id', '=', 'relacione.id_topico')
        ->where('topic_folder.id',$id)
        ->where('topic_folder.user_id', Auth::user()->id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('topic_folder.*') 
        ->first();
            
        $exercises = Exercises::leftJoin('relacione','exercises.id_topic','=','relacione.id_topico')
        ->where('exercises.user_id', Auth::user()->id)
        ->where('exercises.id_topic',$id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('exercises.*')
        ->get();

        $materials = Material::leftJoin('relacione','material.id_topic','=','relacione.id_topico')
        ->where('material.user_id', Auth::user()->id)
        ->where('material.id_topic',$id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('material.*')
        ->get();

        $anotacoes = Anotacao::leftJoin('relacione','anotacao.id_topic','=','relacione.id_topico')
        ->where('anotacao.user_id', Auth::user()->id)
        ->where('anotacao.id_topic',$id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('anotacao.*')
        ->get();
        // dd($anotacoes);

        $parceiros = Relacione::join('users', 'relacione.id_parceiro', '=', 'users.id')
        ->where('relacione.id_topico', $id)
        ->select('users.*')
        ->get();
        // dd($parceiros);

        $arrayEx = [];
        foreach ($exercises as $exercise) {
            $arrayEx[] = [
                'id' => $exercise->id,
                'titulo' => $exercise->titulo,
                'level' => $exercise->level,
                'alternativas' => array_values(array_filter(json_decode($exercise->alternativas, true))),
                'resolucao' => $exercise->resolucao,
            ];
        }
        $converter = new CommonMarkConverter();
        $textoFormatado = $converter->convertToHtml($dados_topico->sobre);
        $topicFormatado = $converter->convertToHtml($dados_topico->topics);

        return view('topico', ['texto' => $textoFormatado,'dados_topico' => $dados_topico,'arrayEx' => $arrayEx,'materials' => $materials,'topicFormatado' => $topicFormatado,'parceiros' => $parceiros,'anotacoes' => $anotacoes]);
    })->name('topico');

    Route::get('/conteudo/{id_topico}/{id_material}/{level}', function ($id_topico,$id_material,$level) {
        $dado_material = Material::leftJoin('relacione','material.id_topic','=','relacione.id_topico')
        ->where('material.user_id', Auth::user()->id)
        ->where('material.id',$id_material)
        ->where('material.id_topic', $id_topico)
        ->where('material.level',$level)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('material.*')
        ->first();

        $dados_topico = Topic_folder::leftJoin('relacione', 'topic_folder.id', '=', 'relacione.id_topico')
        ->where('topic_folder.user_id', Auth::user()->id)
        ->where('topic_folder.id',$id_topico)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('topic_folder.*') 
        ->first();

        $exercises = Exercises::leftJoin('relacione','exercises.id_topic','=','relacione.id_topico')
        ->where('exercises.user_id', Auth::user()->id)
        ->where('exercises.id_topic',$id_topico)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('exercises.*')
        ->get();
        
        $converter = new CommonMarkConverter();
        $textoMD = $converter->convertToHtml($dado_material->content_topic);

        return view('conteudo',['textoMD' => $textoMD,'dados_topico' => $dados_topico,'exercises' => $exercises,'dado_material' => $dado_material]);
    })->name('conteudo');

    Route::post('/verificar-resposta', function (Request $request) {
        $exercise = Exercises::find($request->id_exercise);
        $respostaCorreta = trim($exercise->correta);
        $respostaUsuario = trim($request->resposta);
        $acertou = ($respostaUsuario === $respostaCorreta);

        return response()->json([
            'resultado' => $acertou ? 'correto' : 'errado',
            'mensagem' => $acertou ? 'Resposta correta! 🎉' : 'Resposta errada! ❌',
            'exercicio_id' => $exercise->id,
            'resolucao' => $exercise->resolucao
        ]);
    });

    Route::get('/excluir_parceiro/{id_topico}/{id}', function ($id_topico,$id) {
        $relacione = Relacione::where('id_topico',$id_topico)->where('id_parceiro',$id)->first();
        $relacione->delete();
        return redirect()->back();
    })->name('excluir_parceiro');

    Route::get('/excluir_material/{id}', function ($id) {
        $material = Material::where('id',$id)->first();
        $exercises->delete();
        return redirect()->back();
    })->name('excluir_exercicio');

    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('/delete/{id}',[Controller::class,'delete_topic'])->name('delete_topic');
    Route::post('/add_material',[Controller::class,'add_material'])->name('add_material');
    Route::post('/new_topic_folder',[Controller::class,'new_topic_folder'])->name('new_topic_folder');
    Route::post('/exercise_generator',[Controller::class,'exercise_generator'])->name('exercise_generator');
    Route::post('/relacione',[Controller::class,'relacione'])->name('relacione');
    Route::post('/add_anotacao', [Controller::class, 'add_anotacao'])->name('add_anotacao');
    Route::get('/delete_anotacao/{id}', [Controller::class, 'delete_anotacao'])->name('delete_anotacao');
});
