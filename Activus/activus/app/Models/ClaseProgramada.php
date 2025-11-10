<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseProgramada extends Model
{
    use HasFactory;

    protected $table = 'clase_programada';
    protected $primaryKey = 'ID_Clase_Programada';
    public $timestamps = false;

    protected $fillable = [
        'ID_Clase',
        'ID_Sala',
        'Fecha',
        'Hora_Inicio',
        'Hora_Fin'
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'ID_Clase', 'ID_Clase');
    }
}
