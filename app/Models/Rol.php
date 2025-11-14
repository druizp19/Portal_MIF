<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'ODS.TAB_ROL';
    protected $primaryKey = 'idRol';
    public $timestamps = false;

    protected $fillable = [
        'rol',
    ];
}
