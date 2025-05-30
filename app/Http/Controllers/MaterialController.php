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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        // dd($data_material);

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
        // dd($data_topic);

        $exercises = Exercise::leftJoin('relations','exercises.topic_id','=','relations.topic_id')
            ->where('exercises.topic_id', $material->topic_id)
            ->where(function($query) {
                $query->where('exercises.user_id', auth()->user()->id)
                    ->orWhere('relations.owner_id', auth()->user()->id)
                    ->orWhere('relations.partner_id', auth()->user()->id);
            })
            ->select('exercises.*')
            ->get();
        // dd($exercises);

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
    public function destroy(string $id)
    {
        //
    }
}
