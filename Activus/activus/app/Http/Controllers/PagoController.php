<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    // ==============================
    // VISTA PRINCIPAL
    // ==============================
    public function index()
    {
        return view('pagos.pagos-admin');
    }

    // ==============================
    // LISTAR PAGOS
    // ==============================
    public function listar()
    {
        try {
            $pagos = DB::table('pago')
                ->join('usuario', 'usuario.ID_Usuario', '=', 'pago.ID_Usuario')
                ->select(
                    'pago.ID_Pago',
                    'usuario.ID_Usuario as id',
                    DB::raw('CONCAT(usuario.Nombre, " ", usuario.Apellido) as socio'),
                    'usuario.DNI as dni',
                    DB::raw('DATE_FORMAT(pago.Fecha_Pago, "%Y-%m-%d") as fecha'),
                    DB::raw('DATE_FORMAT(pago.Fecha_Vencimiento, "%Y-%m-%d") as vencimiento'),
                    'pago.Metodo_Pago as metodo',
                    'pago.Estado_Pago as estado',
                    'pago.Monto as monto',
                    'pago.Monto_Total as montoTotal',
                    'pago.Observacion as observacion'
                )
                ->orderByDesc('pago.Fecha_Pago')
                ->get();

            return response()->json($pagos);
        } catch (\Throwable $e) {
            Log::error('Error al listar pagos: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al listar pagos']);
        }
    }

    // ==============================
    // LISTAR MEMBRESÍAS ACTIVAS
    // ==============================
    public function listarMembresias()
    {
        try {
            $membresias = DB::table('tipo_membresia')
                ->select(
                    'ID_Tipo_Membresia as id',
                    'Nombre_Tipo_Membresia as nombre',
                    'Precio as precio',
                    DB::raw('CONCAT(Duracion, " ", Unidad_Duracion) as duracion'),
                    'Descripcion as descripcion'
                )
                ->where('Activo', 1)
                ->orderBy('Precio', 'asc')
                ->get();

            return response()->json($membresias);
        } catch (\Throwable $e) {
            Log::error('Error al listar membresías: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al listar membresías']);
        }
    }

    // ==============================
    // BUSCAR SOCIO (por DNI o ID)
    // ==============================
    public function buscarSocio(Request $request)
    {
        $dni = $request->query('dni');
        $id = $request->query('id');

        if (!$dni && !$id) {
            return response()->json(['success' => false, 'error' => 'Falta DNI o ID']);
        }

        try {
            $query = DB::table('usuario')
                ->select('ID_Usuario as id', 'Nombre', 'Apellido', 'DNI');

            if ($dni) {
                $query->where('DNI', $dni);
            } else {
                $query->where('ID_Usuario', $id);
            }

            $socio = $query->first();

            if ($socio) {
                return response()->json(['success' => true, 'socio' => $socio]);
            } else {
                return response()->json(['success' => false, 'error' => 'Socio no encontrado']);
            }
        } catch (\Throwable $e) {
            Log::error('Error al buscar socio: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al buscar socio']);
        }
    }

    // ==============================
    // AGREGAR NUEVO PAGO
    // ==============================
    public function agregar(Request $request)
    {
        $idSocio = $request->input('idSocio');
        $idAdmin = $request->input('idAdmin');
        $fechaPago = $request->input('fechaPago');
        $fechaVenc = $request->input('fechaVencimiento');
        $metodo = $request->input('metodo');
        $membresias = $request->input('membresias', []);
        $montoTot = (float)$request->input('montoTotal', 0);
        $obs = $request->input('observacion', '');

        if (!$idSocio || !$idAdmin || !$fechaPago || !$metodo || $montoTot <= 0 || empty($membresias)) {
            return response()->json(['success' => false, 'error' => 'Faltan datos obligatorios']);
        }

        $estado = 'Pagado';
        $tipoMov = 'Pago';
        $insertados = [];

        try {
            foreach ($membresias as $idMem) {
                $precio = DB::table('tipo_membresia')
                    ->where('ID_Tipo_Membresia', $idMem)
                    ->value('Precio') ?? 0;

                $idPago = DB::table('pago')->insertGetId([
                    'ID_Membresia_Socio' => null,
                    'ID_Usuario' => $idSocio,
                    'ID_Usuario_Registro' => $idAdmin,
                    'Fecha_Pago' => $fechaPago,
                    'Fecha_Vencimiento' => $fechaVenc,
                    'Hora_Pago' => now()->format('H:i:s'),
                    'Metodo_Pago' => $metodo,
                    'Estado_Pago' => $estado,
                    'Tipo_Movimiento' => $tipoMov,
                    'Observacion' => $obs,
                    'Monto' => $precio,
                    'Monto_Total' => $montoTot,
                    'Saldo_Calculado' => 0
                ]);

                $insertados[] = $idPago;
            }

            return response()->json(['success' => true, 'insertados' => $insertados]);
        } catch (\Throwable $e) {
            Log::error('Error al registrar pago: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al registrar pago']);
        }
    }
}
