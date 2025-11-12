<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RutinaEjercicio extends Pivot
{
    protected $table = 'rutina_ejercicio';
    public $incrementing = false; 
    public $timestamps = false;

    protected $fillable = [
        'ID_Rutina',
        'ID_Ejercicio',
        'Series',
        'Repeticiones',
    ];
}

