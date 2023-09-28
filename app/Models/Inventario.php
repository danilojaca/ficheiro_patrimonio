<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'unidade_id',
        'categoria_id',
        'sala',
        'modelo',
        'n_inventario',
        'n_serie',
        'bem_inventariado',
        'conservacao'
    ];
     
    public function Unidade(){

        return $this->belongsTo('App\Models\Unidades');
     }

     public function RoleUnidades(){

        return $this->belongsTo('App\Models\RoleUnidades');
     }
     public function Categoria(){

      return $this->belongsTo('App\Models\Ben');
   }
}
