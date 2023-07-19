<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    use HasFactory;
    protected $fillable = [
        'edificio_id',
        'unidade',
        
    ];

    public function Edificio(){

        return $this->belongsTo('App\Models\Edificio');
     }
}
