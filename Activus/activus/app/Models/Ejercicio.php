<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ejercicio extends Model
{
    protected $table = 'ejercicio';
    protected $primaryKey = 'ID_Ejercicio';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Ejercicio',
        'Descripcion',
        'Tips',
        'Instrucciones',
    ];

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'ejercicio_equipo', 'ID_Ejercicio', 'ID_Equipo');
    }

    public function musculos()
    {
        return $this->belongsToMany(Musculo::class, 'ejercicio_musculo', 'ID_Ejercicio', 'ID_Musculo');
    }

    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class, 'rutina_ejercicio', 'ID_Ejercicio', 'ID_Rutina');
    }

}
