<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $table = 'ODS.TAB_SISTEMA';
    protected $primaryKey = 'idSistema';
    public $timestamps = false;

    protected $fillable = [
        'sistema',
    ];
}
