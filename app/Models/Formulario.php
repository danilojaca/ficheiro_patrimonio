<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;
    protected $table = 'inventarios';
    
    public function Edificio(){

        return $this->belongsTo('App\Edificio');
     }
}
