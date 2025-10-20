<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Clase;
use Illuminate\Support\Facades\DB;

class ProfesoresController extends Controller
{

    public function obtenerProfesoresSocio()
    {
        $profesores = Usuario::whereHas('roles', function ($q) {
            $q->where('Nombre_Rol', 'Profesor');
        })
            ->whereHas('estadoUsuario', function ($q) {
                $q->where('Nombre_Estado_Usuario', 'Activo');
            })
            ->select('Nombre', 'Apellido', 'Email')
            ->get();

        return response()->json($profesores);
    }

    public function obtenerProfesoresAdmin()
    {
        $profesores = Usuario::withCount('clases')
            ->whereHas('roles', function ($q) {
                $q->where('Nombre_Rol', 'Profesor');
            })
            ->with('estadoUsuario') //  agregada en el model Usuario
            ->select('ID_Usuario', 'Nombre', 'Apellido', 'Email', 'Telefono', 'ID_Estado_Usuario')
            ->get()
            ->map(function ($p) {
                return [
                    'ID_Usuario' => $p->ID_Usuario,
                    'Nombre' => $p->Nombre,
                    'Apellido' => $p->Apellido,
                    'Email' => $p->Email,
                    'Telefono' => $p->Telefono ?? 'Sin teléfono',
                    'Estado' => $p->estadoUsuario->Nombre_Estado_Usuario ?? 'Desconocido',
                    'clases_count' => $p->clases_count
                ];
            });

        return response()->json($profesores);
    }

    public function obtenerMetricas()
    {
        $totalProfesores = Usuario::whereHas('roles', function ($q) {
            $q->where('Nombre_Rol', 'Profesor');
        })->count();


        $profesoresActivos = Usuario::whereHas('roles', function ($q) {
            $q->where('Nombre_Rol', 'Profesor');
        })
            ->whereHas('estadoUsuario', function ($q) {
                $q->where('Nombre_Estado_Usuario', 'Activo');
            })
            ->count();


        $clasesAsignadas = Clase::count();

        return response()->json([
            'totalProfesores' => $totalProfesores,
            'profesoresActivos' => $profesoresActivos,
            'clasesAsignadas' => $clasesAsignadas
        ]);
    }
}
