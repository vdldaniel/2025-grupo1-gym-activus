<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoUsuario extends Model
{
    protected $table = 'estado_usuario';
    protected $primaryKey = 'ID_Estado_Usuario';
    protected $fillable = ['Nombre_Estado_Usuario'];
    public $timestamps = false;

}
