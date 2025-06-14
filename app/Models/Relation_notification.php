<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation_notification extends Model
{
    protected $fillable = [
        'user_id',
        'data_id',
        'partner_id',
        'type'
    ];
}
