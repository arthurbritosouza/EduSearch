<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic_folder extends Model
{    
    protected $fillable = [
        'user_id',
        'name',
        'matter',
        'summary',
        'about',
        'topics'
    ];
}