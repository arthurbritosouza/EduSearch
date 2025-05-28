<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{    
    protected $fillable = [
        'user_id', // Adicione esta linha
        'topic_id',
        'content_topic',
        'name_material',
        'level'
    ];
}