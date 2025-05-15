<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relacione extends Model
{
    //
    protected $table = 'relacione';
    protected $fillable = [
        'user_id',
        'id_topic',
        'id_dono',
        'id_parceiro'
    ];
}