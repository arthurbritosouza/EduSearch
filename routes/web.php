<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercises;
use App\Models\Relacione;
use App\Models\Anotacao;
use App\Models\Users;
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
        $user = Users::find(Auth::user()->id);

        $folders = Topic_folder::where('user_id', Auth::user()->id)->get();

        $relacionados = Topic_folder::join('relacione', 'topic_folder.id', '=', 'relacione.id_topic')
        ->where('relacione.id_parceiro', Auth::user()->id)
        ->select('topic_folder.*') 
        ->get(); 

        return view('home',compact('folders','relacionados','user'));
    })->name('home');

    Route::get('/topico/{id}', function ($id) {
        $user = Users::find(Auth::user()->id);

        $data_topic = Topic_folder::leftJoin('relacione', 'topic_folder.id', '=', 'relacione.id_topic')
        ->where('topic_folder.id',$id)
        ->where('topic_folder.user_id', Auth::user()->id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('topic_folder.*') 
        ->first();
        
            
        $exercises = Exercises::leftJoin('relacione','exercises.id_topic','=','relacione.id_topic')
        ->where('exercises.user_id', Auth::user()->id)
        ->where('exercises.id_topic',$id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('exercises.*')
        ->get();

        $materials = Material::leftJoin('relacione','material.id_topic','=','relacione.id_topic')
        ->where('material.user_id', Auth::user()->id)
        ->where('material.id_topic',$id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('material.*')
        ->get();        

        $anotacoes = Anotacao::leftJoin('relacione','anotacao.id_topic','=','relacione.id_topic')
        ->where('anotacao.user_id', Auth::user()->id)
        ->where('anotacao.id_topic',$id)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('anotacao.*')
        ->get();
        // dd($anotacoes);

        $parceiros = Relacione::join('users', 'relacione.id_parceiro', '=', 'users.id')
        ->where('relacione.id_topic', $id)
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
        $textoFormatado = $converter->convertToHtml($data_topic->sobre);
        $topicFormatado = $converter->convertToHtml($data_topic->topics);

        
        return view('topico', ['user' => $user,'texto' => $textoFormatado,'data_topic' => $data_topic,'arrayEx' => $arrayEx,'materials' => $materials,'topicFormatado' => $topicFormatado,'parceiros' => $parceiros,'anotacoes' => $anotacoes]);
    })->name('topico');

    Route::get('/conteudo/{id_topic}/{id_material}/{level}', function ($id_topic,$id_material,$level) {
        $user = Users::find(Auth::user()->id);

        $data_material = Material::leftJoin('relacione','material.id_topic','=','relacione.id_topic')
        ->where('material.user_id', Auth::user()->id)
        ->where('material.id',$id_material)
        ->where('material.id_topic', $id_topic)
        ->where('material.level',$level)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('material.*')
        ->first();

        // dd($data_material->id);

        $data_topic = Topic_folder::leftJoin('relacione', 'topic_folder.id', '=', 'relacione.id_topic')
        ->where('topic_folder.user_id', Auth::user()->id)
        ->where('topic_folder.id',$id_topic)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('topic_folder.*') 
        ->first();

        $exercises = Exercises::leftJoin('relacione','exercises.id_topic','=','relacione.id_topic')
        ->where('exercises.user_id', Auth::user()->id)
        ->where('exercises.id_topic',$id_topic)
        ->orWhere('relacione.id_parceiro', Auth::user()->id)
        ->select('exercises.*')
        ->get();
        
        $converter = new CommonMarkConverter();
        $textoMD = $converter->convertToHtml($data_material->content_topic);

        return view('conteudo',['user' => $user,'textoMD' => $textoMD,'data_topic' => $data_topic,'exercises' => $exercises,'data_material' => $data_material]);
    })->name('conteudo');

    Route::post('/verificar-resposta', function (Request $request) {
        try {
            // Validar os dados de entrada
            $request->validate([
                'id_exercise' => 'required|numeric',
                'resposta' => 'required|string',
            ]);

            // Buscar o exercício no banco de dados
            $exercise = Exercises::findOrFail($request->id_exercise);
            
            // Normalizar as respostas para comparação (remover espaços extras, converter para minúsculas)
            $respostaCorreta = strtolower(trim($exercise->correta));
            $respostaUsuario = strtolower(trim($request->resposta));
            
            // Verificar se a resposta está correta
            $acertou = ($respostaUsuario === $respostaCorreta);

            // Retornar resposta com informações detalhadas
            return response()->json([
                'status' => 'success',
                'resultado' => $acertou ? 'correto' : 'errado',
                'mensagem' => $acertou ? 'Resposta correta! 🎉' : 'Resposta errada! ❌',
                'exercicio_id' => $exercise->id,
                'resolucao' => $exercise->resolucao,
                'resposta_correta' => $exercise->correta,
                'resposta_usuario' => $request->resposta
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Ocorreu um erro ao verificar a resposta.',
                'error' => $e->getMessage()
            ], 500);
        }
    });
        
    Route::post('/edit_topic', function (Request $request) {
        $id_topic = $request->input('id_topic');
        $name_topic = $request->input('name_topic');
        Topic_folder::where('id',$id_topic)->update(['name' => $name_topic]);
        return redirect()->back()->withSuccess('Nome alterado com sucesso!');
    })->name('excluir_parceiro');

    Route::get('/excluir_parceiro/{id_topic}/{id_parceiro}', function ($id_topic,$id_parceiro) {
        Relacione::where('id_topic',$id_topic)->where('id_parceiro',$id_parceiro)->delete();
        return redirect()->back()->withErrors('Parceiro excluído com sucesso!');
    })->name('excluir_parceiro');

    Route::get('/excluir_material/{id_topic}/{id_material}', function ($id_topic,$id_material) {
        Material::where('id',$id_material)->delete();
        return redirect()->route('topico',['id' => $id_topic])->withErrors('Material excluído com sucesso!');
    })->name('excluir_material');

    Route::get('/excluir_anotacao/{id}', function ($id) {
        Anotacao::where('id',$id)->delete();
        return redirect()->back()->withErrors('Anotação excluída com sucesso!');
    })->name('excluir_anotacao');

    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('/delete/{id}',[Controller::class,'delete_topic'])->name('delete_topic');
    Route::post('/add_material',[Controller::class,'add_material'])->name('add_material');
    Route::post('/new_topic_folder',[Controller::class,'new_topic_folder'])->name('new_topic_folder');
    Route::post('/exercise_generator',[Controller::class,'exercise_generator'])->name('exercise_generator');
    Route::post('/relacione',[Controller::class,'relacione'])->name('relacione');
    Route::post('/add_anotacao', [Controller::class, 'add_anotacao'])->name('add_anotacao');
});
