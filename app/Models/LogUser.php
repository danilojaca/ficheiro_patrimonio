<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogUser extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user',
        'log',
        'operacao',
        'ip_remoto',
    ];

    public function User(){

        return $this->belongsTo('App\Models\User');
     }
}
