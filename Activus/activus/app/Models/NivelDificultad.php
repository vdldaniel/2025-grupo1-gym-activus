<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelDificultad extends Model
{
    protected $table = 'nivel_dificultad';
    protected $primaryKey = 'ID_Nivel_Dificultad';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Nivel_Dificultad',
    ];
}

