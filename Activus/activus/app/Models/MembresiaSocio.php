<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembresiaSocio extends Model
{
    protected $table = 'membresia_socio';
    protected $primaryKey = 'ID_Membresia_Socio';
    public $timestamps = false;

    protected $fillable = [
        'ID_Usuario_Socio',
        'ID_Tipo_Membresia',
        'ID_Estado_Membresia_Socio',
        'Fecha_Inicio',
        'Fecha_Fin',
    ];
}
