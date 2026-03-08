<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
    'situation',
    'original_text',
    'key_points',
    'summary',
    'reflection',
    'self_score',
];
}
