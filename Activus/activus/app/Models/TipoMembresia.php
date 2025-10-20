<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMembresia extends Model
{
    protected $table = 'tipo_membresia';
    protected $primaryKey = 'ID_Tipo_Membresia';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Tipo_Membresia',
        'Duracion',
        'Unidad_Duracion',
        'Precio',
        'Descripcion'

    ];




}
