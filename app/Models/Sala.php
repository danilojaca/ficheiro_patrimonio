<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'sala',
        'unidade_id',
        'edificio_id'
    ];
}
