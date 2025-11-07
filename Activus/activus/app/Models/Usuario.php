<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Clase;

class Usuario extends Authenticatable
{
    use HasFactory;
    use Notifiable;

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
    // Laravel usa este método internamente para validar el password
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }

    // Para que Auth reconozca el campo del email correctamente
    public function getAuthIdentifierName()
    {
        return 'Email';
    }

    public function setContrasenaAttribute($value)
    {
        $this->attributes['Contrasena'] = Hash::make($value);
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'ID_Usuario', 'ID_Rol');
    }

    public function permisos()
    {
        return $this->roles()->with('permisos')->get()->pluck('permisos')->flatten()->pluck('Nombre_Permiso')->unique();
    }

    public function scopeConRol($query, string $nombreRol)
    {
        return $query->whereHas('roles', function ($q) use ($nombreRol) {
            $q->where('rol.Nombre_Rol', $nombreRol);
        });
    }
    public function clases()
    {
        return $this->hasMany(Clase::class, 'ID_Profesor', 'ID_Usuario');
    }

    public function estadoUsuario()
    {
        return $this->belongsTo(EstadoUsuario::class, 'ID_Estado_Usuario', 'ID_Estado_Usuario');
    }

    public function socio()
    {
        return $this->hasOne(Socio::class, 'ID_Usuario', 'ID_Usuario');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'ID_Usuario_Socio', 'ID_Usuario');
    }

    public function membresia()
    {
        return $this->hasOne(MembresiaSocio::class, 'ID_Usuario_Socio', 'ID_Usuario');
    }
}
