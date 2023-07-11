<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUnidades extends Model
{
    use HasFactory;
    protected $table = 'permission_unidades';
    protected $fillable = [
      'user_id',
      'edificio_id',
      
  ];

    public function Edificio(){

        return $this->belongsTo('App\Models\Edificio');
     }

     public function User(){

        return $this->belongsTo('App\Models\User');
     }
}
