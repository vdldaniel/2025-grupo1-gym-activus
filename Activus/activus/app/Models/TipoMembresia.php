<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MembresiaSocio;

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
    public function socios()
    {
        return $this->hasMany(MembresiaSocio::class, 'ID_Tipo_Membresia');
    }



}
