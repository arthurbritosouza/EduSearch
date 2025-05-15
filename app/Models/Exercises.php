<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    //
    protected $table = 'exercises';

    protected $fillable = [
            'user_id',
            'id_topic',
            'titulo',
            'alternativas',
            'resolucao',
            'correta',
            'level'
    ];
}