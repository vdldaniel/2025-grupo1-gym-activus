<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permiso';
    protected $primaryKey = 'ID_Permiso';
    protected $fillable = ['Nombre_Permiso'];
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_permiso', 'ID_Permiso', 'ID_Rol');
    }
}
