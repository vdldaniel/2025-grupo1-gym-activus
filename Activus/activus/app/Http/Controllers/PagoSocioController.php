<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PagoSocioController extends Controller
{
    /**
     * Vista principal del módulo de pagos del socio.
     */
    public function index()
    {
        return view('pagos.socio');
    }

    /**
     * Devuelve los datos del socio logueado:
     * - Membresía actual
     * - Vencimiento del próximo pago
     * - Historial de pagos
     */
    public function listar()
    {
        try {
            //  ID del socio (usar Auth::id() cuando esté activo el login)
            $idSocio = Auth::id() ?? 10; // Cambiá este número para probar con otro socio

            if (!$idSocio) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró sesión activa del socio.'
                ], 401);
            }

            $hoy = Carbon::now()->toDateString();

            //  Actualizar membresías vencidas
            DB::table('membresia_socio')
                ->where('ID_Usuario_Socio', $idSocio)
                ->whereDate('Fecha_Fin', '<', $hoy)
                ->update(['Estado_Membresia' => 'Vencida']);

            //  Obtener membresía actual o más reciente
            $membresia = DB::table('membresia_socio AS ms')
                ->join('tipo_membresia AS tm', 'tm.ID_Tipo_Membresia', '=', 'ms.ID_Tipo_Membresia')
                ->where('ms.ID_Usuario_Socio', $idSocio)
                ->orderByDesc('ms.ID_Membresia_Socio')
                ->select(
                    'tm.Nombre_Tipo_Membresia AS tipo',
                    'tm.Precio AS precio',
                    'ms.Estado_Membresia AS estado',
                    'ms.Fecha_Fin AS vencimiento'
                )
                ->first();

            if (!$membresia) {
                return response()->json([
                    'success' => true,
                    'membresia' => [
                        'tipo' => '-',
                        'precio' => 0,
                        'estado' => 'Inactiva'
                    ],
                    'proximoPago' => [
                        'vencimiento' => null,
                        'diasRestantes' => null
                    ],
                    'pagos' => []
                ]);
            }

            //  Calcular días restantes
            $vencimiento = new \DateTime($membresia->vencimiento);
            $diff = (new \DateTime($hoy))->diff($vencimiento);
            $diasRestantes = (int)$diff->format('%r%a');

            //  Historial de pagos
            $pagos = DB::table('pago AS p')
                ->join('membresia_socio AS ms', 'p.ID_Membresia_Socio', '=', 'ms.ID_Membresia_Socio')
                ->join('tipo_membresia AS tm', 'ms.ID_Tipo_Membresia', '=', 'tm.ID_Tipo_Membresia')
                ->where('p.ID_Usuario_Socio', $idSocio)
                ->orderByDesc('p.Fecha_Pago')
                ->select(
                    DB::raw("DATE_FORMAT(p.Fecha_Pago, '%Y-%m-%d') AS fecha"),
                    'tm.Nombre_Tipo_Membresia AS plan',
                    'p.Metodo_Pago AS metodo',
                    'p.Monto AS monto',
                    'ms.Estado_Membresia AS estado'
                )
                ->get();

            // 🔹 Respuesta al frontend
            return response()->json([
                'success' => true,
                'membresia' => [
                    'tipo' => $membresia->tipo,
                    'precio' => $membresia->precio,
                    'estado' => $membresia->estado
                ],
                'proximoPago' => [
                    'vencimiento' => $membresia->vencimiento,
                    'diasRestantes' => $diasRestantes
                ],
                'pagos' => $pagos
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los datos del socio.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
