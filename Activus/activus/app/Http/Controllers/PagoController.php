<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PagoController extends Controller
{
    /**
     * Vista principal del módulo de pagos (administrativo)
     */
    public function index()
    {
        return view('pagos.pagos-admin');
    }

    /**
     * Listar pagos para la tabla del administrativo
     */
    public function listar()
    {
        try {
            $pagos = DB::table('pago')
                ->join('membresia_socio', 'pago.ID_Membresia_Socio', '=', 'membresia_socio.ID_Membresia_Socio')
                ->join('usuario', 'membresia_socio.ID_Usuario_Socio', '=', 'usuario.ID_Usuario')
                ->join('tipo_membresia', 'membresia_socio.ID_Tipo_Membresia', '=', 'tipo_membresia.ID_Tipo_Membresia')
                ->leftJoin(
                    'estado_membresia_socio',
                    'membresia_socio.ID_Estado_Membresia_Socio',
                    '=',
                    'estado_membresia_socio.ID_Estado_Membresia_Socio'
                )
                ->select(
                    'pago.ID_Pago as id',
                    DB::raw("CONCAT(usuario.Nombre, ' ', usuario.Apellido) as socio"),
                    'usuario.DNI as dni',
                    'tipo_membresia.Nombre_Tipo_Membresia as plan',
                    DB::raw("COALESCE(estado_membresia_socio.Nombre_Estado_Membresia_Socio, 'Sin estado') as estado"),
                    'membresia_socio.Fecha_Fin as fecha_vencimiento',
                    'pago.Monto as monto',
                    'pago.Fecha_Pago as fecha_pago',
                    'pago.Metodo_Pago as metodo',
                    'pago.Observacion as observacion'
                )
                ->orderByDesc('pago.Fecha_Pago')
                ->get();

            return response()->json($pagos);
        } catch (\Throwable $e) {
            Log::error('Error al listar pagos: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al listar pagos.',
            ], 500);
        }
    }

    /**
     * Listar tipos de membresía (para los checkboxes)
     */
    public function listar_membresias()
    {
        try {
            $membresias = DB::table('tipo_membresia')
                ->select(
                    'ID_Tipo_Membresia as id',
                    'Nombre_Tipo_Membresia as nombre',
                    'Duracion as duracion',
                    'Unidad_Duracion as unidad',
                    'Precio as precio'
                )
                ->orderBy('Nombre_Tipo_Membresia')
                ->get();

            return response()->json($membresias);
        } catch (\Throwable $e) {
            Log::error('Error al cargar membresías: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las membresías.',
            ], 500);
        }
    }

    /**
     * Buscar socio por DNI o ID (solo socios)
     */
    public function buscar_socio(Request $request)
    {
        try {
            $dni = $request->query('dni');
            $id  = $request->query('id');

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

            if (!$socio) {
                return response()->json([
                    'success' => false,
                    'message' => 'Socio no encontrado.',
                ]);
            }

            return response()->json([
                'success' => true,
                'socio'   => $socio,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al buscar socio: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al buscar socio.',
            ], 500);
        }
    }

    /**
     * Registrar pago:
     *  - Actualiza / crea membresia_socio
     *  - Inserta en pago (uno por cada membresía seleccionada)
     */
    public function agregar(Request $request)
    {
        // 🔐 Validaciones
        $request->validate([
            'idSocio'          => 'required|integer',
            'metodo'           => 'required|string',
            'fechaPago'        => 'required|date',
            'items'            => 'required|array|min:1',
            'items.*.idTipoMembresia'   => 'required|integer',
            'items.*.fechaVencimiento'  => 'required|date',
        ]);

        $idSocio     = $request->idSocio;
        $fechaPago   = $request->fechaPago;
        $metodo      = $request->metodo;
        $observacion = $request->observacion ?: null;
        $items       = $request->input('items', []);

        $fechaPagoCarbon = Carbon::parse($fechaPago);

        // 💡 ESTE ES EL USUARIO LOGUEADO (SIEMPRE ID NUMÉRICO)
        $idUsuarioRegistro = Auth::user()->ID_Usuario ?? null;

        if (!$idUsuarioRegistro) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        try {
            DB::beginTransaction();

            // ID del estado "Activa" (por si cambia el ID)
            $idEstadoActiva = DB::table('estado_membresia_socio')
                ->where('Nombre_Estado_Membresia_Socio', 'Activa')
                ->value('ID_Estado_Membresia_Socio') ?? 1;

            foreach ($items as $item) {
                $idTipoMembresia  = $item['idTipoMembresia'] ?? null;
                $fechaVencimiento = $item['fechaVencimiento'] ?? null;

                if (!$idTipoMembresia || !$fechaVencimiento) {
                    throw new \Exception('Datos de membresía incompletos.');
                }

                $fechaVencCarbon = Carbon::parse($fechaVencimiento);

                if ($fechaVencCarbon->lt($fechaPagoCarbon)) {
                    throw new \Exception('La fecha de vencimiento no puede ser anterior a la fecha de pago.');
                }

                // ¿Ya existe una membresía de ese tipo para el socio?
                $membresiaSocio = DB::table('membresia_socio')
                    ->where('ID_Usuario_Socio', $idSocio)
                    ->where('ID_Tipo_Membresia', $idTipoMembresia)
                    ->first();

                if ($membresiaSocio) {
                    // Actualizar membresía existente
                    $idMembresiaSocio = $membresiaSocio->ID_Membresia_Socio;

                    DB::table('membresia_socio')
                        ->where('ID_Membresia_Socio', $idMembresiaSocio)
                        ->update([
                            'ID_Estado_Membresia_Socio' => $idEstadoActiva,
                            'Fecha_Inicio'              => $fechaPago,
                            'Fecha_Fin'                 => $fechaVencimiento,
                        ]);
                } else {
                    // Crear nueva membresía para el socio
                    $idMembresiaSocio = DB::table('membresia_socio')->insertGetId([
                        'ID_Usuario_Socio'          => $idSocio,
                        'ID_Tipo_Membresia'         => $idTipoMembresia,
                        'ID_Estado_Membresia_Socio' => $idEstadoActiva,
                        'Fecha_Inicio'              => $fechaPago,
                        'Fecha_Fin'                 => $fechaVencimiento,
                    ]);
                }

                // Precio actual de ese tipo de membresía
                $precio = DB::table('tipo_membresia')
                    ->where('ID_Tipo_Membresia', $idTipoMembresia)
                    ->value('Precio');

                if ($precio === null) {
                    $precio = 0;
                }

                // Registrar el pago (uno por cada membresía)
                DB::table('pago')->insert([
                    'ID_Membresia_Socio'  => $idMembresiaSocio,
                    'ID_Usuario_Socio'    => $idSocio,
                    'ID_Usuario_Registro' => $idUsuarioRegistro,
                    'Monto'               => $precio,
                    'Fecha_Pago'          => $fechaPago,
                    'Fecha_Vencimiento'   => $fechaVencimiento,
                    'Metodo_Pago'         => $metodo,
                    'Observacion'         => $observacion,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago registrado con éxito.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error al registrar pago: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el pago.',
            ], 500);
        }
    }
}
