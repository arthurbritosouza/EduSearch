<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
            'user_id',
            'topic_id',
            'title',
            'alternatives',
            'resolution',
            'correct',
            'level'
    ];
}