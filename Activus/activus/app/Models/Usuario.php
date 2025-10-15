<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'ID_Usuario';
    public $timestamps = false;

    protected $fillable = [
        'ID_Estado_Usuario',
        'Nombre',
        'Apellido',
        'Contrasena',
        'Email',
        'DNI',
        'Foto_Perfil',
        'Telefono',
        'Fecha_Alta',
    ];

    public function setContrasenaAttribute($value)
    {
        $this->attributes['Contrasena'] = Hash::make($value);
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Rol::class, 'usuario_rol', 'ID_Usuario', 'ID_Rol');
    }

    public function scopeConRol($query, string $nombreRol)
    {
        return $query->whereHas('roles', function($q) use ($nombreRol) {
            $q->where('rol.Nombre_Rol', $nombreRol);
        });
    }



}
