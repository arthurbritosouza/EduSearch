<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\Note;
use App\Models\User;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/topico/{id}', function ($id) {
    $user = User::find(Auth::user()->id);

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
    // dd($materials);
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

    return view('topico', ['user' => $user,'texto' => $textoFormatado,'data_topic' => $data_topic,'arrayEx' => $arrayEx,'materials' => $materials,'topicFormatado' => $topicFormatado,'parceiros' => $parceiros,'anotacoes' => $anotacoes]);
})->name('topico');

Route::get('/conteudo/{topic_id}/{id_material}/{level}', function ($topic_id,$id_material,$level) {
    $user = User::find(Auth::user()->id);

    $data_material = Material::leftJoin('relations','materials.topic_id','=','relations.topic_id')
    ->where('materials.topic_id', $topic_id)
    ->where('materials.id',$id_material)
    ->where('materials.level',$level)
    ->where(function($query) {
        $query->where('materials.user_id', Auth::user()->id)
                ->orWhere('relations.owner_id', Auth::user()->id)
                ->orWhere('relations.partner_id', Auth::user()->id);
    })
    ->select('materials.*')
    ->distinct()
    ->first();

    $data_topic = Topic_folder::leftJoin('relations', 'topic_folders.id', '=', 'relations.topic_id')
    ->where('topic_folders.id',$topic_id)
    ->where(function($query) {
        $query->where('topic_folders.user_id', Auth::user()->id)
                ->orWhere('relations.owner_id', Auth::user()->id)
                ->orWhere('relations.partner_id', Auth::user()->id);
    })
    ->select('topic_folders.*') 
    ->distinct()
    ->first();

    $exercises = Exercise::leftJoin('relations','exercises.topic_id','=','relations.topic_id')
    ->where('exercises.topic_id',$topic_id)
    ->where(function($query) {
        $query->where('exercises.user_id', Auth::user()->id)
                ->orWhere('relations.owner_id', Auth::user()->id)
                ->orWhere('relations.partner_id', Auth::user()->id);
    })
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
        $exercise = Exercise::findOrFail($request->id_exercise);
        
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
    $topic_id = $request->input('topic_id');
    $name_topic = $request->input('name_topic');
    Topic_folder::where('id',$topic_id)->update(['name' => $name_topic]);
    return redirect()->back()->withSuccess('Nome alterado com sucesso!');
})->name('edit_topic');

Route::get('/excluir_parceiro/{topic_id}/{partner_id}', function ($topic_id,$partner_id) {
    relations::where('topic_id',$topic_id)->where('partner_id',$partner_id)->delete();
    return redirect()->back()->withErrors('Parceiro excluído com sucesso!');
})->name('excluir_parceiro');

Route::get('/excluir_material/{topic_id}/{id_material}', function ($topic_id,$id_material) {
    Material::where('id',$id_material)->delete();
    return redirect()->route('topico',['id' => $topic_id])->withErrors('Material excluído com sucesso!');
})->name('excluir_material');

Route::get('/excluir_anotacao/{id}', function ($id) {
    Note::where('id',$id)->delete();
    return redirect()->back()->withErrors('Anotação excluída com sucesso!');
})->name('excluir_anotacao');

Route::get('logout', [LoginController::class, 'logout']);
Route::get('/delete/{id}',[Controller::class,'delete_topic'])->name('delete_topic');
Route::post('/add_material',[Controller::class,'add_material'])->name('add_material');
Route::post('/new_topic_folder',[Controller::class,'new_topic_folder'])->name('new_topic_folder');
Route::post('/exercise_generator',[Controller::class,'exercise_generator'])->name('exercise_generator');
Route::post('/relations',[Controller::class,'relations'])->name('relations');
Route::post('/add_anotacao', [Controller::class, 'add_anotacao'])->name('add_anotacao');