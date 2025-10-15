<?php

namespace App\Helpers;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class PermisoHelper
{

        
    public static function tienePermiso($permiso, $idUsuario)
    {
        $usuario = Usuario::find($idUsuario);
        if (!$usuario) return false;

        if (!is_array($permiso)) {
            $permisos = [$permiso]; 
        } else {
            $permisos = $permiso;
        }
        return self::tieneAlgunPermiso($permisos, $idUsuario);
    }

    public static function tieneAlgunPermiso(array $permisos, $idUsuario)
    {
        $usuario = Usuario::find($idUsuario);
        if (!$usuario || empty($permisos)) {
            return false;
        }

        $permisosUsuario = $usuario->permisos();
        return $permisosUsuario->intersect($permisos)->isNotEmpty();
    }

    public static function obtenerPermisos($idUsuario)
    {
        $usuario = Usuario::find($idUsuario);
        if (!$usuario) return collect();
        return $usuario->permisos();
    }

    public static function obtenerRoles($idUsuario)
    {
        $usuario = Usuario::find($idUsuario);
        if (!$usuario) return collect();
        return $usuario->roles;
    }

    public static function esRol($rol, $idUsuario)
    {
        if (is_null($rol) || is_null($idUsuario)) {
            return false;
        }
        if (!is_array($rol)) {
            $roles = [$rol];
        } else {
            $roles = $rol;
        }
        return self::esAlgunRol($roles, $idUsuario);
    }

    public static function esAlgunRol($roles, $idUsuario)
    {
        /** @var \PDO $conn */
        global $conn;
        if (is_null($roles) || !is_array($roles) || empty($roles) || is_null($idUsuario)) {
            return false;
        }
        $bindRoles = implode(',', array_map(function ($p, $k) {
            return ":rol$k";
        }, $roles, array_keys($roles)));
        $sql = "
            SELECT 
                1 
            FROM 
                rol
            INNER JOIN
                usuario_rol
                    ON
                        usuario_rol.ID_Rol = rol.ID_Rol
            WHERE 
                    usuario_rol.ID_Usuario = :idUsuario
                AND rol.Nombre_Rol IN (" . $bindRoles . ")
            LIMIT 1;
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idUsuario', $idUsuario);
        array_walk($roles, function ($p, $k) use ($stmt) {
            $stmt->bindValue(":rol$k", $p);
        });
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return !empty($result);
    }
}
