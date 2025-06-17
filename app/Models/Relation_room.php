<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation_room extends Model
{
        protected $fillable = [
        'user_id',
        'room_id',
        'owner_id',
        'partner_id',
        'role'
    ];
}
