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

    public function estadoMembresiaSocio()
    {
        return $this->belongsTo(EstadoMembresiaSocio::class, 'ID_Estado_Membresia_Socio', 'ID_Estado_Membresia_Socio');
    }

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'ID_Usuario_Socio', 'ID_Usuario');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoMembresia::class, 'ID_TipoMembresia', 'ID_TipoMembresia');
    }

    public function tipoMembresia()
    {
        return $this->belongsTo(TipoMembresia::class, 'ID_Tipo_Membresia', 'ID_Tipo_Membresia');
    }
}
