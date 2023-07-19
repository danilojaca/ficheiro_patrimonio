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
      'unidade_id',
      
  ];

    public function Unidade(){

        return $this->belongsTo('App\Models\Unidades');
     }

     public function User(){

        return $this->belongsTo('App\Models\User');
     }
}
