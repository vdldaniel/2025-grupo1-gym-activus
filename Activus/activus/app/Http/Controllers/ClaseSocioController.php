<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClaseSocioController extends Controller
{
    // ==========================================
    //   VISTA PRINCIPAL
    // ==========================================
    public function index()
    {
        return view('clases.socio.index');
    }


    // ==========================================
    //   EVENTOS PARA EL CALENDARIO
    // ==========================================
    public function eventos()
    {
        $idSocio = Auth::user()->ID_Usuario;

        $eventos = DB::table('reserva as r')
            ->join('clase_programada as cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
            ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
            ->select(
                'c.Nombre_Clase',
                'cp.Fecha',
                'cp.Hora_Inicio',
                'cp.Hora_Fin'
            )
            ->where('r.ID_Socio', $idSocio)
            ->where('r.Estado_Reserva', 'Confirmada')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->Nombre_Clase,
                    'start' => $item->Fecha . 'T' . $item->Hora_Inicio,
                    'end' => $item->Fecha . 'T' . $item->Hora_Fin,
                ];
            });

        return response()->json($eventos);
    }


    // ==========================================
    //   LISTAR CLASES DISPONIBLES
    // ==========================================

    //a diferencia de la funcion comentada esta trae solo las clases programadas que no ocurrieron calculando fecha-hora
    public function disponibles()
    {
        $idSocio = Auth::user()->ID_Usuario;

        $ahora = now(); // fecha y hora actual

        $clases = DB::table('clase_programada as cp')
            ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
            ->leftJoin('usuario as u', 'c.ID_Profesor', '=', 'u.ID_Usuario')
            ->leftJoin('sala as s', 'cp.ID_Sala', '=', 's.ID_Sala')
            ->leftJoin('reserva as r', function ($join) use ($idSocio) {
                $join->on('cp.ID_Clase_Programada', '=', 'r.ID_Clase_Programada')
                    ->where('r.ID_Socio', '=', $idSocio);
            })
            ->select(
                'cp.ID_Clase_Programada',
                'c.Nombre_Clase',
                DB::raw("CONCAT(u.Nombre, ' ', u.Apellido) as Profesor"),
                'c.Capacidad_Maxima',
                's.Nombre_Sala as Sala',
                'cp.Fecha',
                'cp.Hora_Inicio',
                'cp.Hora_Fin',
                DB::raw('(SELECT COUNT(*) 
                  FROM reserva r2 
                      WHERE r2.ID_Clase_Programada = cp.ID_Clase_Programada 
                        AND r2.Estado_Reserva = "Confirmada") as Capacidad_Usada'),
                'r.ID_Reserva'
            )

            ->where(function ($q) use ($ahora) {
                $q->where('cp.Fecha', '>', $ahora->toDateString())
                    ->orWhere(function ($q2) use ($ahora) {
                        $q2->where('cp.Fecha', '=', $ahora->toDateString())
                            ->where('cp.Hora_Inicio', '>', $ahora->format('H:i:s'));
                    });
            })
            ->orderBy('cp.Fecha')
            ->orderBy('cp.Hora_Inicio')
            ->get();

        return response()->json($clases);
    }




    /*  public function disponibles()
      {
          $idSocio = Auth::user()->ID_Usuario;

          $clases = DB::table('clase_programada as cp')
              ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
              ->leftJoin('usuario as u', 'c.ID_Profesor', '=', 'u.ID_Usuario')
              ->leftJoin('sala as s', 'cp.ID_Sala', '=', 's.ID_Sala')
              ->leftJoin('reserva as r', function ($join) use ($idSocio) {
                  $join->on('cp.ID_Clase_Programada', '=', 'r.ID_Clase_Programada')
                      ->where('r.ID_Socio', '=', $idSocio);
              })
              ->select(
                  'cp.ID_Clase_Programada',
                  'c.Nombre_Clase',
                  DB::raw("CONCAT(u.Nombre, ' ', u.Apellido) as Profesor"),
                  'c.Capacidad_Maxima',
                  's.Nombre_Sala as Sala',
                  'cp.Fecha',
                  'cp.Hora_Inicio',
                  'cp.Hora_Fin',
                  DB::raw('(SELECT COUNT(*) 
                            FROM reserva r2 
                            WHERE r2.ID_Clase_Programada = cp.ID_Clase_Programada 
                              AND r2.Estado_Reserva = "Confirmada") as Capacidad_Usada'),
                  'r.ID_Reserva'
              )
              ->orderBy('cp.Fecha')
              ->orderBy('cp.Hora_Inicio')
              ->get();

          return response()->json($clases);
      }
  */

    // ==========================================
    //   INSCRIBIRSE A UNA CLASE
    // ==========================================
    public function inscribirse($idClase)
    {
        $idSocio = Auth::user()->ID_Usuario;

        try {
            // Verificar capacidad
            $capacidad = DB::table('clase_programada as cp')
                ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
                ->where('cp.ID_Clase_Programada', $idClase)
                ->select(
                    'c.Capacidad_Maxima',
                    DB::raw('(SELECT COUNT(*) 
                            FROM reserva r 
                            WHERE r.ID_Clase_Programada = cp.ID_Clase_Programada 
                                AND r.Estado_Reserva = "Confirmada") as ocupados')
                )
                ->first();

            if ($capacidad && $capacidad->ocupados >= $capacidad->Capacidad_Maxima) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay cupos disponibles en esta clase.'
                ]);
            }

            // Verificar reserva duplicada
            $yaReservada = DB::table('reserva')
                ->where('ID_Clase_Programada', $idClase)
                ->where('ID_Socio', $idSocio)
                ->where('Estado_Reserva', 'Confirmada')
                ->exists();

            if ($yaReservada) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya estás inscrito en esta clase.'
                ]);
            }

            // Insertar reserva
            DB::table('reserva')->insert([
                'ID_Clase_Programada' => $idClase,
                'ID_Socio' => $idSocio,
                'Fecha_Reserva' => now()->format('Y-m-d'),
                'Estado_Reserva' => 'Confirmada'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Inscripción exitosa.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al inscribirse: ' . $e->getMessage(),
            ]);
        }
    }


    // ==========================================
    //   CANCELAR INSCRIPCIÓN (con 24h de anticipación)
    // ==========================================
    public function cancelar($idClase)
    {
        $idSocio = Auth::user()->ID_Usuario;

        // Buscar reserva
        $reserva = DB::table('reserva')
            ->where('ID_Clase_Programada', $idClase)
            ->where('ID_Socio', $idSocio)
            ->where('Estado_Reserva', 'Confirmada')
            ->first();

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'message' => 'No estás inscripto en esta clase.'
            ], 404);
        }

        // Buscar fecha real de la clase
        $clase = DB::table('clase_programada')
            ->where('ID_Clase_Programada', $idClase)
            ->first();

        if (!$clase) {
            return response()->json([
                'success' => false,
                'message' => 'La clase no existe.'
            ], 404);
        }

        // Validar 24h
        $fechaClase = Carbon::parse($clase->Fecha . ' ' . $clase->Hora_Inicio);
        $ahora = Carbon::now();

        if ($ahora->diffInHours($fechaClase, false) < 24) {
            return response()->json([
                'success' => false,
                'motivo' => 'fuera_de_tiempo',
                'message' => 'Solo puedes cancelar con 24 horas de anticipación.'
            ]);
        }

        // Cancelar reserva
        DB::table('reserva')
            ->where('ID_Reserva', $reserva->ID_Reserva)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inscripción cancelada correctamente.'
        ]);
    }


    // ==========================================
    //   MÉTRICAS DE CLASES
    // ==========================================
    public function metricas()
    {
        $idSocio = Auth::user()->ID_Usuario;

        $total = DB::table('reserva')
            ->where('ID_Socio', $idSocio)
            ->where('Estado_Reserva', 'Confirmada')
            ->count();

        $hoy = DB::table('reserva as r')
            ->join('clase_programada as cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
            ->where('r.ID_Socio', $idSocio)
            ->where('r.Estado_Reserva', 'Confirmada')
            ->whereDate('cp.Fecha', now('America/Argentina/Buenos_Aires')->toDateString())

            ->count();

        return response()->json([
            'total' => $total,
            'hoy' => $hoy
        ]);
    }


    // ==========================================
    //   MIS CLASES PARA CALENDARIO
    // ==========================================
    public function misClasesCalendario()
    {
        $idSocio = Auth::user()->ID_Usuario;

        $clases = DB::table('reserva as r')
            ->join('clase_programada as cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
            ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
            ->join('sala as s', 'cp.ID_Sala', '=', 's.ID_Sala')
            ->where('r.ID_Socio', $idSocio)
            ->where('r.Estado_Reserva', 'Confirmada')
            ->select(
                'c.Nombre_Clase as title',
                DB::raw('CONCAT(cp.Fecha, " ", cp.Hora_Inicio) as start'),
                DB::raw('CONCAT(cp.Fecha, " ", cp.Hora_Fin) as end'),
                's.Nombre_Sala as sala'
            )
            ->get();

        return response()->json($clases);
    }
}
