<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_spms',
        'id_siie',
        'edificio',
        'concelho',
        'aces',
        'morada',
        'ip_router',
        'cp',
        'dias_funcionamento',
        'horarios_funcionamento'
    ];
}
