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
            // ================================
            // ID DEL PROFESOR LOGUEADO
            // ================================
            $idProfesor = Auth::id();

            if (!$idProfesor) {
                return response()->json([
                    'success' => false,
                    'error' => 'No hay sesión activa.'
                ], 401);
            }

            // ================================
            // TOTAL DE ESTUDIANTES CONFIRMADOS HOY
            // ================================
            $totalEstudiantes = DB::table('reserva as r')
                ->join('clase_programada as cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
                ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
                ->where('c.ID_Profesor', $idProfesor)
                ->where('r.Estado_Reserva', 'Confirmada')
                ->whereDate('cp.Fecha', DB::raw('CURDATE()'))
                ->distinct('r.ID_Socio')
                ->count('r.ID_Socio');

            // ================================
            // TOTAL DE CLASES ACTIVAS DEL PROFESOR
            // ================================
            $totalClases = DB::table('clase')
                ->where('ID_Profesor', $idProfesor)
                ->count();

            // ================================
            // CLASES PROGRAMADAS PARA HOY (DETALLE)
            // ================================
            $clasesHoy = DB::table('clase_programada as cp')
                ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
                ->join('sala as s', 'cp.ID_Sala', '=', 's.ID_Sala')
                ->leftJoin('reserva as r', function ($join) {
                    $join->on('r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
                         ->where('r.Estado_Reserva', '=', 'Confirmada');
                })
                ->select(
                    'c.Nombre_Clase as nombre',
                    's.Nombre_Sala as sala',
                    'cp.Hora_Inicio as hora_inicio',
                    'cp.Hora_Fin as hora_fin',
                    'c.Capacidad_Maxima as capacidad',
                    DB::raw('COUNT(r.ID_Reserva) as reservas_confirmadas')
                )
                ->where('c.ID_Profesor', $idProfesor)
                ->whereDate('cp.Fecha', DB::raw('CURDATE()'))
                ->groupBy('c.Nombre_Clase', 's.Nombre_Sala', 'cp.Hora_Inicio', 'cp.Hora_Fin', 'c.Capacidad_Maxima')
                ->orderBy('cp.Hora_Inicio')
                ->get();

            // ================================
            // RESPUESTA JSON
            // ================================
            return response()->json([
                'success' => true,
                'data' => [
                    'totalEstudiantes' => $totalEstudiantes,
                    'variacionEstudiantes' => 'Estudiantes inscriptos en las clases de hoy',
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
