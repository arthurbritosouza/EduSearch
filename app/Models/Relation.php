<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    //
    protected $fillable = [
        'user_id',
        'topic_id',
        'room_id',
        'owner_id',
        'partner_id'
    ];
}
