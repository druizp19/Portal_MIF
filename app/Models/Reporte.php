<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'ODS.TAB_REPORTE';
    protected $primaryKey = 'idReporte';
    public $timestamps = false;

    protected $fillable = [
        'reporte',
        'descripcion',
        'imagen',
    ];
}
