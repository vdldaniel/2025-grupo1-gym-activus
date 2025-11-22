<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InicioSocioController extends Controller
{
    public function index()
    {
        return view('inicio.socio');
    }

    public function obtenerDatos()
    {
        try {
            $idSocio = Auth::id();

            if (!$idSocio) {
                return response()->json([
                    'success' => false,
                    'error' => 'No hay sesión activa.'
                ], 401);
            }

            // ================================
            // MEMBRESÍA ACTIVA
            // ================================
            $membresia = DB::table('membresia_socio AS ms')
                ->join('tipo_membresia AS tm', 'ms.ID_Tipo_Membresia', '=', 'tm.ID_Tipo_Membresia')
                ->join('estado_membresia_socio AS ems', 'ms.ID_Estado_Membresia_Socio', '=', 'ems.ID_Estado_Membresia_Socio')
                ->select(
                    'tm.Nombre_Tipo_Membresia AS tipo',
                    'tm.Precio AS precio',
                    'ems.Nombre_Estado_Membresia_Socio AS estado',
                    'ms.Fecha_Inicio AS inicio',
                    'ms.Fecha_Fin AS fin'
                )
                ->where('ms.ID_Usuario_Socio', $idSocio)
                ->where('ems.Nombre_Estado_Membresia_Socio', 'Activa')
                ->orderByDesc('ms.ID_Membresia_Socio')
                ->first();

            // ================================
            // PRÓXIMO PAGO (USAR MEMBRESÍA ACTIVA)
            // ================================
            if ($membresia) {
                $vencimiento = Carbon::parse($membresia->fin);
                $diasRestantes = Carbon::now()->diffInDays($vencimiento, false);

                $proximoPago = [
                    'vencimiento' => $vencimiento->format('d/m/Y'),
                    'diasRestantes' => max($diasRestantes, 0),
                    'estado' => $diasRestantes >= 0 ? 'Activa' : 'Vencida'
                ];
            } else {
                $proximoPago = [
                    'vencimiento' => 'Sin membresía',
                    'diasRestantes' => 0,
                    'estado' => 'Inactiva'
                ];
            }


            // ================================
            // CLASES RESERVADAS HOY
            // ================================
            $clasesHoy = DB::table('reserva AS r')
                ->join('clase_programada AS cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
                ->join('clase AS c', 'cp.ID_Clase', '=', 'c.ID_Clase')
                ->select('c.Nombre_Clase', 'cp.Fecha')
                ->where('r.ID_Socio', $idSocio)
                ->whereDate('cp.Fecha', Carbon::today())
                ->get();

            return response()->json([
                'success'      => true,
                'membresia'    => $membresia ?? [
                    'tipo'   => 'Sin membresía',
                    'precio' => 0,
                    'estado' => 'Inactiva'
                ],
                'proximoPago'  => $proximoPago,
                'clasesHoy'    => $clasesHoy
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        }
    }
}

