<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionGym extends Model
{
    protected $table = 'configuracion_gym';
    protected $primaryKey = 'ID_Configuracion_Gym';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ID_Admin',
        'Nombre_Gym',
        'Ubicacion',
        'Logo_PNG',
        'ID_Color_Fondo',
        'Color_Elemento'
    ];


    public function colorFondo()
    {
        return $this->belongsTo(ColorFondo::class, 'ID_Color_Fondo', 'ID_Color_Fondo');
    }

    public function horarios()
    {
        return $this->hasMany(HorarioFuncionamiento::class, 'ID_Configuracion_Gym', 'ID_Configuracion_Gym');
    }
}