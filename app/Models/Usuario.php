<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Model
{
    protected $table = 'ODS.TAB_USUARIO';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'correo',
        'usuario',
        'correoBi',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'ODS.TAB_USUARIO_ROL', 'idUsuario', 'idRol')
            ->withPivot('idSistema');
    }

    public function reportes(): BelongsToMany
    {
        return $this->belongsToMany(Reporte::class, 'ODS.TAB_USUARIO_REPORTE', 'idUsuario', 'idReporte');
    }
}
