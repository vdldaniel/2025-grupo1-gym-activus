<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InicioProfesorController extends Controller
{
    public function index()
    {
        return view('inicio.profesor');
    }

    public function datos()
    {
        try {
            // ID del profesor logueado o fijo para pruebas
            $idProfesor = Auth::id() ?? 10;

            // ================================
            // TOTAL DE ESTUDIANTES (opcional por ahora)
            // ================================
            $totalEstudiantes = 0; // temporal hasta que conectes asistencia

            // ================================
            // TOTAL DE CLASES ACTIVAS
            // ================================
            $totalClases = DB::table('clase')
                ->where('ID_Profesor', $idProfesor)
                ->count();

            // ================================
            // CLASES PROGRAMADAS PARA HOY
            // ================================
            $clasesHoy = DB::table('clase_programada as cp')
                ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
                ->join('sala as s', 'cp.ID_Sala', '=', 's.ID_Sala')
                ->select(
                    'c.Nombre_Clase as nombre',
                    's.Nombre_Sala as sala',
                    'cp.Hora_Inicio as hora_inicio',
                    'cp.Hora_Fin as hora_fin'
                )
                ->where('c.ID_Profesor', $idProfesor)
                ->whereDate('cp.Fecha', DB::raw('CURDATE()'))
                ->get();

            // ================================
            // RESPUESTA JSON
            // ================================
            return response()->json([
                'success' => true,
                'data' => [
                    'totalEstudiantes' => $totalEstudiantes,
                    'variacionEstudiantes' => '+12% desde el mes pasado',
                    'totalClases' => $totalClases,
                    'variacionClases' => $clasesHoy->count() . ' programadas para hoy',
                    'clasesHoy' => $clasesHoy
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
