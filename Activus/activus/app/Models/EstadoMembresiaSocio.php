<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoMembresiaSocio extends Model
{
    protected $table = 'estado_membresia_socio';
    protected $primaryKey = 'ID_Estado_Membresia_Socio';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Estado_Membresia_Socio',
    ];

    
}
