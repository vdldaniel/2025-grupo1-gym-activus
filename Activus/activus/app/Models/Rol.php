<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'ID_Rol';
    protected $fillable = ['Nombre_Rol'];
    public $timestamps = false;


    public function usuarios() {
    return $this->belongsToMany(Usuario::class, 'usuario_rol', 'ID_Rol', 'ID_Usuario');
    }

    public function permisos(){
        return $this->belongsToMany(Permiso::class, 'rol_permiso', 'ID_Rol', 'ID_Permiso');
    }
}
