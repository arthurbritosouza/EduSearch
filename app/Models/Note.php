<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = [
        'user_id',
        'topic_id',
        'title',
        'annotation',
    ];
}