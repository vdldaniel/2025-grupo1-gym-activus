<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencia'; // nombre  de la tabla
    protected $primaryKey = 'ID_Asistencia';
    public $timestamps = false;

    protected $fillable = [
        'ID_Socio',
        'Fecha',
        'Hora',
        'Resultado'
    ];
}
