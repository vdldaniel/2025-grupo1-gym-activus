<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\MembresiaSocio;
use App\Models\Asistencia;

class IngresoFisicoController extends Controller
{
    public function verificarIngreso(Request $request)
    {
        $request->validate([
            'dni' => 'required|numeric'
        ]);

        $dni = $request->dni;

        // buscar usuario
        $usuario = Usuario::where('DNI', $dni)->first();

        if (!$usuario) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'No existe un usuario con ese DNI'
            ]);
        }

        // 
        $rol = $usuario->roles->first()->ID_Rol ?? null;

        //socios
        if ($rol == 4) {

            $membresia = MembresiaSocio::where('ID_Usuario_Socio', $usuario->ID_Usuario)
                ->with('estadoMembresiaSocio')
                ->first();

            if (!$membresia) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'El socio no tiene una membresía registrada'
                ]);
            }

            $estado = $membresia->estadoMembresiaSocio->Nombre_Estado_Membresia_Socio;

            // membresia vencida
            if ($estado === 'Vencida') {

                Asistencia::create([
                    'ID_Usuario' => $usuario->ID_Usuario,
                    'Fecha' => date('Y-m-d'),
                    'Hora' => date('H:i:s'),
                    'Resultado' => 'Denegado'
                ]);

                return response()->json([
                    'status' => 'denegado',
                    'mensaje' => 'Acceso denegado — Membresía vencida',
                    'rol' => $rol
                ]);
            }

            // si la membresia esta activa o pendiente pasa
            Asistencia::create([
                'ID_Usuario' => $usuario->ID_Usuario,
                'Fecha' => date('Y-m-d'),
                'Hora' => date('H:i:s'),
                'Resultado' => 'Exitoso'
            ]);

            return response()->json([
                'status' => 'permitido',
                'mensaje' => 'Acceso permitido — Membresía ' . $estado,
                'nombre' => $usuario->Nombre,
                'apellido' => $usuario->Apellido,
                'rol' => $rol
            ]);
        }

        // no es socio , deja entrar siempre

        Asistencia::create([
            'ID_Usuario' => $usuario->ID_Usuario,
            'Fecha' => date('Y-m-d'),
            'Hora' => date('H:i:s'),
            'Resultado' => 'Exitoso'
        ]);

        return response()->json([
            'status' => 'permitido',
            'mensaje' => 'Ingreso registrado correctamente',
            'nombre' => $usuario->Nombre,
            'apellido' => $usuario->Apellido,
            'rol' => $rol
        ]);
    }
}
