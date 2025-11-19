<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipo';
    protected $primaryKey = 'ID_Equipo';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Equipo',
    ];

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'ejercicio_equipo', 'ID_Equipo', 'ID_Ejercicio');
    }

    
}
