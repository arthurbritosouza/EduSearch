<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Room_content extends Model
{
    protected $fillable = [
    'user_id',
    'room_id',
    'content_id',
    'content_type',
];
}
