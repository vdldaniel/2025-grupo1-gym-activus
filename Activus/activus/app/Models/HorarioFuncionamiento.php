<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioFuncionamiento extends Model
{
    protected $table = 'horario_funcionamiento';
    protected $primaryKey = 'ID_Horario_Funcionamiento';
    public $timestamps = false;

    protected $fillable = [
        'ID_Configuracion_Gym',
        'Dia_Semana',
        'Hora_Apertura',
        'Hora_Cierre',
        'Habilitacion'
    ];

    public function configuracion()
    {
        return $this->belongsTo(ConfiguracionGym::class, 'ID_Configuracion_Gym', 'ID_Configuracion_Gym');
    }
}
