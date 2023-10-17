<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edificio extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
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
