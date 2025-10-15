<?php

namespace App\Http\Controllers;
use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function obtenerAsistenciasHoy()
    {
        $hoy = date('Y-m-d');

        $asistencias = \DB::table('asistencia')
            ->join('socio', 'asistencia.ID_Socio', '=', 'socio.ID_Usuario')
            ->join('usuario', 'socio.ID_Usuario', '=', 'usuario.ID_Usuario')
            ->select(
                'usuario.Nombre',
                'usuario.Apellido',
                'usuario.DNI',
                'asistencia.Hora',
                'asistencia.Resultado'
            )
            ->whereDate('asistencia.Fecha', $hoy)
            ->get();

        return response()->json($asistencias);
    }
}
