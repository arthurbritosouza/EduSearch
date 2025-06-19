<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\TopicController;
use App\Models\Topic_folder;
use App\Models\Material;
use App\Models\Exercise;
use App\Models\Relation;
use App\Models\Note;
use App\Models\User;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::resource('topic', TopicController::class);

Route::post('addAnnotation', [TopicController::class, 'addAnnotation'])->name('topic.addAnnotation');
Route::delete('deleteAnnotation', [TopicController::class, 'deleteAnnotation'])->name('topic.deleteAnnotation');

Route::post('/exercise_generator',[TopicController::class,'exercise_generator'])->name('topic.exercise_generator');
Route::post('/relations',[TopicController::class,'relations'])->name('topic.relations');
























































Route::post('/verificar-resposta', function (Request $request)
{
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

Route::get('/excluir_parceiro/{topic_id}/{partner_id}', function ($topic_id,$partner_id)
{
    Relation::where('topic_id',$topic_id)->where('partner_id',$partner_id)->delete();
    return redirect()->back()->withErrors('Parceiro excluído com sucesso!');
})->name('excluir_parceiro');

Route::get('/excluir_material/{topic_id}/{id_material}', function ($topic_id,$id_material)
{
    Material::where('id',$id_material)->delete();
    return redirect()->route('topico',['id' => $topic_id])->withErrors('Material excluído com sucesso!');
})->name('excluir_material');

Route::get('/excluir_anotacao/{id}', function ($id)
{
    Note::where('id',$id)->delete();
    return redirect()->back()->withErrors('Anotação excluída com sucesso!');
})->name('excluir_anotacao');

