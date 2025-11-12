<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $table = 'clase';
    protected $primaryKey = 'ID_Clase';
    public $timestamps = false;

    protected $fillable = [
        'ID_Profesor',
        'Nombre_Clase',
        'Capacidad_Maxima',
    ];


    public function profesor()
    {
        return $this->belongsTo(Usuario::class, 'ID_Profesor', 'ID_Usuario');
    }
    public function clasesProgramadas()
    {
        return $this->hasMany(ClaseProgramada::class, 'ID_Clase', 'ID_Clase');
    }
}
