<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InicioAdminController extends Controller
{
    /**
     * Muestra la vista principal del inicio administrativo.
     */
    public function index()
    {
        // Fecha actual
        $hoy = date('Y-m-d');

        // Total de socios activos (rol 4)
        $totalSocios = DB::table('usuario_rol')
            ->join('usuario', 'usuario_rol.ID_Usuario', '=', 'usuario.ID_Usuario')
            ->where('usuario_rol.ID_Rol', 4) // Rol Socio
            ->count();

        // Clases programadas para hoy
        $clasesHoy = DB::table('clase_programada')
            ->join('clase', 'clase_programada.ID_Clase', '=', 'clase.ID_Clase')
            ->leftJoin('usuario', 'clase.ID_Profesor', '=', 'usuario.ID_Usuario')
            ->select(
                'clase_programada.Fecha',
                'clase_programada.Hora_Inicio',
                'clase_programada.Hora_Fin',
                'clase.Nombre_Clase',
                'usuario.Nombre as Profesor'
            )
            ->whereDate('clase_programada.Fecha', $hoy)
            ->orderBy('clase_programada.Hora_Inicio')
            ->get();

        // Total de clases activas hoy
        $totalClases = $clasesHoy->count();

        // IMPORTANTE → enviar $hoy a la vista
        return view('inicio.administrativo', compact('hoy', 'totalSocios', 'totalClases', 'clasesHoy'));
    }

    /**
     * Devuelve datos del dashboard del administrador (AJAX)
     */
    public function resumen()
    {
        try {
            $hoy = date('Y-m-d');

            // Total de socios activos
            $totalSocios = DB::table('usuario_rol')
                ->join('usuario', 'usuario_rol.ID_Usuario', '=', 'usuario.ID_Usuario')
                ->where('usuario_rol.ID_Rol', 4)
                ->count();

            // Clases del día
            $clasesHoy = DB::table('clase_programada')
                ->join('clase', 'clase_programada.ID_Clase', '=', 'clase.ID_Clase')
                ->leftJoin('usuario', 'clase.ID_Profesor', '=', 'usuario.ID_Usuario')
                ->select(
                    'clase_programada.Fecha',
                    'clase_programada.Hora_Inicio',
                    'clase_programada.Hora_Fin',
                    'clase.Nombre_Clase',
                    'usuario.Nombre as Profesor'
                )
                ->whereDate('clase_programada.Fecha', $hoy)
                ->orderBy('clase_programada.Hora_Inicio')
                ->get();

            return response()->json([
                'success' => true,
                'totalSocios' => $totalSocios,
                'totalClases' => $clasesHoy->count(),
                'clasesHoy'   => $clasesHoy
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }
}
