<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic_folder extends Model
{
    //
    protected $table = 'topic_folder';
    
    protected $fillable = [
        'user_id', // Adicione esta linha
        'name',
        'materia',
        'resumo',
        'sobre',
        'topics'
    ];
}