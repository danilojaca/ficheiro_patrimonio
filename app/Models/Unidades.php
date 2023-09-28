<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidades extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'edificio_id',
        'unidade',
        
    ];

    protected $dates = ['deleted_at'];
    public function Edificio(){

        return $this->belongsTo('App\Models\Edificio');
     }
}
