<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reserva';
    protected $primaryKey = 'ID_Reserva';
    public $timestamps = false;

    protected $fillable = [
        'ID_Clase_Programada',
        'ID_Socio',
        'Fecha_Reserva',
        'Estado_Reserva',
    ];

    // Relación con ClaseProgramada
    public function claseProgramada()
    {
        return $this->belongsTo(ClaseProgramada::class, 'ID_Clase_Programada', 'ID_Clase_Programada');
    }
}
