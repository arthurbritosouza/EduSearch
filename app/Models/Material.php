<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    protected $table = 'material';
    
    protected $fillable = [
        'user_id', // Adicione esta linha
        'id_topic',
        'content_topic',
        'name_material',
        'level'
    ];
}