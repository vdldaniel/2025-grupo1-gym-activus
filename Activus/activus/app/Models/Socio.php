<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Socio extends Usuario
{
    protected $table = 'socio';
    protected $primaryKey = 'ID_Usuario';
    public $timestamps = false;

    protected $fillable = [
        'ID_Usuario',
        'Fecha_Nacimiento',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ID_Usuario');
    }

    public function membresias()
    {
        return $this->belongsToMany(TipoMembresia::class, 'membresia_socio', 'ID_Usuario_Socio', 'ID_Tipo_Membresia');
    }

    public function membresiaSocio()
    {
        return $this->hasMany(MembresiaSocio::class, 'ID_Usuario_Socio', 'ID_Usuario');
    }




}
