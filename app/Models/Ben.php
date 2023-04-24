<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ben extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria',
        'sub_categoria'
    ];
}
