<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorFondo extends Model
{
    protected $table = 'colores_fondo';
    protected $primaryKey = 'ID_Color_Fondo';
    public $timestamps = false;

    protected $fillable = ['Nombre_Color', 'Codigo_Hex'];

    public function configuraciones()
    {
        return $this->hasMany(ConfiguracionGym::class, 'ID_Color_Fondo', 'ID_Color_Fondo');
    }
}
