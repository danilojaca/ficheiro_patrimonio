<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulario extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'inventarios';
    
    public function Edificio(){

        return $this->belongsTo('App\Edificio');
     }
     public function Categoria(){

        return $this->belongsTo('App\Models\Ben');
     }
     public function Unidade(){

      return $this->belongsTo('App\Models\Unidades');
   }
}
