<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PagoController extends Controller
{
    /**
     * Vista principal de pagos (administrativo)
     */
    public function index()
    {
        return view('pagos.pagos-admin');
    }

    /**
     * Listar todos los pagos con estado real de la membresía
     */
    public function listar()
    {
        $hoy = Carbon::now()->toDateString();

        // 🔄 Actualizar estados automáticamente según las fechas
        $membresias = DB::table('membresia_socio')->get();

        foreach ($membresias as $m) {
            $estadoNuevo = $m->Estado_Membresia;

            if ($m->Fecha_Fin && $m->Fecha_Fin < $hoy) {
                $estadoNuevo = 'Vencida';
            } elseif ($m->Fecha_Inicio && $m->Fecha_Inicio > $hoy) {
                $estadoNuevo = 'Pendiente';
            } else {
                $estadoNuevo = 'Activa';
            }

            if ($estadoNuevo !== $m->Estado_Membresia) {
                DB::table('membresia_socio')
                    ->where('ID_Membresia_Socio', $m->ID_Membresia_Socio)
                    ->update(['Estado_Membresia' => $estadoNuevo]);
            }
        }

        // 📋 Consultar pagos con estado actualizado
        $pagos = DB::table('pago')
            ->join('membresia_socio', 'pago.ID_Membresia_Socio', '=', 'membresia_socio.ID_Membresia_Socio')
            ->join('usuario', 'membresia_socio.ID_Usuario_Socio', '=', 'usuario.ID_Usuario')
            ->join('tipo_membresia', 'membresia_socio.ID_Tipo_Membresia', '=', 'tipo_membresia.ID_Tipo_Membresia')
            ->select(
                'pago.ID_Pago as id',
                DB::raw("CONCAT(usuario.Nombre, ' ', usuario.Apellido) as socio"),
                'usuario.DNI as dni',
                'tipo_membresia.Nombre_Tipo_Membresia as plan',
                'membresia_socio.Estado_Membresia as estado',
                'membresia_socio.Fecha_Fin as fecha_vencimiento',
                'pago.Monto as monto',
                'pago.Fecha_Pago as fecha_pago',
                'pago.Metodo_Pago as metodo',
                'pago.Observacion as observacion'
            )
            ->orderByDesc('pago.Fecha_Pago')
            ->get();

        return response()->json($pagos);
    }

    /**
     * Listar membresías disponibles
     */
    public function listar_membresias()
    {
        $membresias = DB::table('tipo_membresia')
            ->select(
                'ID_Tipo_Membresia as id',
                'Nombre_Tipo_Membresia as nombre',
                'Duracion as duracion',
                'Precio as precio'
            )
            ->orderBy('nombre')
            ->get();

        return response()->json($membresias);
    }

    /**
     * Buscar socio por DNI o ID
     */
    public function buscar_socio(Request $request)
    {
        $dni = $request->query('dni');
        $id = $request->query('id');

        $query = DB::table('usuario')
            ->join('usuario_rol', 'usuario.ID_Usuario', '=', 'usuario_rol.ID_Usuario')
            ->join('rol', 'usuario_rol.ID_Rol', '=', 'rol.ID_Rol')
            ->where('rol.Nombre_Rol', 'Socio');

        if ($dni) {
            $query->where('usuario.DNI', $dni);
        } elseif ($id) {
            $query->where('usuario.ID_Usuario', $id);
        }

        $socio = $query->select(
            'usuario.ID_Usuario as id',
            'usuario.Nombre',
            'usuario.Apellido',
            'usuario.DNI'
        )->first();

        if ($socio) {
            return response()->json(['success' => true, 'socio' => $socio]);
        }

        return response()->json(['success' => false, 'message' => 'Socio no encontrado']);
    }

    /**
     * Registrar nuevo pago
     */
    public function agregar(Request $request)
    {
        $request->validate([
            'idSocio' => 'required|integer',
            'metodo' => 'required|string',
            'fechaPago' => 'required|date',
            'fechaVencimiento' => 'required|date',
            'membresias' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->membresias as $idMembresia) {

                // 🔍 Verificar si el socio ya tiene esa membresía
                $membresiaSocio = DB::table('membresia_socio')->where([
                    ['ID_Usuario_Socio', $request->idSocio],
                    ['ID_Tipo_Membresia', $idMembresia],
                ])->first();

                if (!$membresiaSocio) {
                    // ➕ Crear una nueva membresía
                    $idMembresiaSocio = DB::table('membresia_socio')->insertGetId([
                        'ID_Usuario_Socio' => $request->idSocio,
                        'ID_Tipo_Membresia' => $idMembresia,
                        'Fecha_Inicio' => $request->fechaPago,
                        'Fecha_Fin' => $request->fechaVencimiento,
                        'Estado_Membresia' => 'Activa',
                    ]);
                } else {
                    // 🔄 Actualizar fechas y estado de la existente
                    $idMembresiaSocio = $membresiaSocio->ID_Membresia_Socio;

                    DB::table('membresia_socio')
                        ->where('ID_Membresia_Socio', $idMembresiaSocio)
                        ->update([
                            'Fecha_Inicio' => $request->fechaPago,
                            'Fecha_Fin' => $request->fechaVencimiento,
                            'Estado_Membresia' => 'Activa',
                        ]);
                }

                // 💰 Obtener precio de la membresía
                $precio = DB::table('tipo_membresia')
                    ->where('ID_Tipo_Membresia', $idMembresia)
                    ->value('Precio');

                // 🧾 Registrar el pago
                DB::table('pago')->insert([
                    'ID_Membresia_Socio' => $idMembresiaSocio,
                    'ID_Usuario_Socio' => $request->idSocio,
                    'ID_Usuario_Registro' => auth()->id() ?? 1,
                    'Monto' => $precio,
                    'Fecha_Pago' => $request->fechaPago,
                    'Metodo_Pago' => $request->metodo,
                    'Observacion' => $request->observacion ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pago registrado con éxito']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el pago',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
