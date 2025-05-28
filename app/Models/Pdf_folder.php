<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf_folder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'summary',
        'content',
        'pages',
        'size',
        'words',
        'language'
    ];
}
