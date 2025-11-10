<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InicioSocioController extends Controller
{
    /**
     * Vista principal
     */
    public function index()
    {
        return view('inicio.socio');
    }

    /**
     * Devuelve los datos dinámicos del socio logueado.
     */
    public function obtenerDatos()
    {
        try {
            // ID del socio logueado (temporal para pruebas)
            $idSocio = Auth::id() ?? 9; // ← Cambiar según ID real de prueba

            // ================================
            // MEMBRESÍA ACTIVA
            // ================================
            $membresia = DB::table('membresia_socio AS ms')
                ->join('tipo_membresia AS tm', 'ms.ID_Tipo_Membresia', '=', 'tm.ID_Tipo_Membresia')
                ->select(
                    'tm.Nombre_Tipo_Membresia AS tipo',
                    'tm.Precio AS precio',
                    'ms.Estado_Membresia AS estado',
                    'ms.Fecha_Inicio AS inicio',
                    'ms.Fecha_Fin AS fin'
                )
                ->where('ms.ID_Usuario_Socio', $idSocio)
                ->where('ms.Estado_Membresia', 'Activa')
                ->orderByDesc('ms.ID_Membresia_Socio')
                ->first();

            // ================================
            // PRÓXIMO PAGO
            // ================================
            $ultimoPago = DB::table('pago')
                ->where('ID_Usuario_Socio', $idSocio)
                ->orderByDesc('Fecha_Pago')
                ->first();

            if ($ultimoPago) {
                $vencimiento = Carbon::parse($ultimoPago->Fecha_Vencimiento);
                $diasRestantes = Carbon::now()->diffInDays($vencimiento, false);
                $proximoPago = [
                    'vencimiento' => $vencimiento->format('d/m/Y'),
                    'diasRestantes' => $diasRestantes >= 0 ? $diasRestantes : 0
                ];
            } else {
                $proximoPago = [
                    'vencimiento' => 'Sin registros',
                    'diasRestantes' => 0
                ];
            }

            // ================================
            //  CLASES DE HOY (ejemplo)
            // ================================
            $clasesHoy = DB::table('reserva AS r')
                ->join('clase AS c', 'r.ID_Clase_Programada', '=', 'c.ID_Clase')
                ->select('c.Nombre_Clase', 'r.Fecha_Reserva AS Fecha', 'r.Estado_Reserva AS Estado')
                ->where('r.ID_Socio', $idSocio)
                ->whereDate('r.Fecha_Reserva', Carbon::today())
                ->get();

            // ================================
            // RESPUESTA JSON
            // ================================
            return response()->json([
                'success' => true,
                'membresia' => $membresia ?? [
                    'tipo' => 'Sin membresía',
                    'precio' => 0,
                    'estado' => 'Inactiva'
                ],
                'proximoPago' => $proximoPago,
                'clasesHoy' => $clasesHoy
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
