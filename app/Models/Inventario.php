<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $fillable = [
        'edificio_id',
        'categoria',
        'sala',
        'modelo',
        'n_inventario',
        'n_serie',
        'bem_inventariado',
        'conservacao'
    ];
     
    public function Edificio(){

        return $this->belongsTo('App\Models\Edificio');
     }
}
