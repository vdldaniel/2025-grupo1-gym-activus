<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Rutina extends Model
{
    protected $table = 'rutina';
    protected $primaryKey = 'ID_Rutina';
    public $timestamps = false;

    protected $fillable = [
        'ID_Profesor',
        'ID_Nivel_Dificultad',
        'Nombre_Rutina',
        'Duracion_Aprox',
        'Cant_Dias_Semana',
        'Descripcion',
    ];

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'rutina_ejercicio', 'ID_Rutina', 'ID_Ejercicio')
                    ->withPivot('Series', 'Repeticiones');
    }

    public function nivelDificultad()
    {
        return $this->belongsTo(NivelDificultad::class, 'ID_Nivel_Dificultad', 'ID_Nivel_Dificultad');
    }


}
