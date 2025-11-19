<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClaseSocioController extends Controller
{
    /**
     * Vista principal del módulo de clases del socio.
     */
    public function index()
    {
        return view('clases.socio.index');
    }

    /**
     * Devuelve las clases reservadas del socio logueado para mostrar en el calendario.
     */
    public function eventos()
    {
        $idSocio = Auth::id() ?? 6; // reemplazá con Auth real si ya tenemos sesión

        // Une reservas con clases programadas y clases
        $eventos = DB::table('reserva as r')
            ->join('clase_programada as cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
            ->join('clase as c', 'cp.ID_Clase', '=', 'c.ID_Clase')
            ->select(
                'r.ID_Reserva',
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
                    'end'   => $item->Fecha . 'T' . $item->Hora_Fin,
                ];
            });

        return response()->json($eventos);
    }

    /**
     * Devuelve las clases disponibles (no reservadas por el socio).
     */
    public function disponibles()
    {
        $idSocio = Auth::id() ?? 6;

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
                DB::raw('(SELECT COUNT(*) FROM reserva WHERE ID_Clase_Programada = cp.ID_Clase_Programada AND Estado_Reserva = "Confirmada") as Capacidad_Usada'),
                'r.ID_Reserva'
            )
            ->whereNull('r.ID_Reserva') // no mostrar las que ya reservó
            ->get();

        return response()->json($clases);
    }

    /**
     * Permite al socio inscribirse en una clase (reserva confirmada).
     */
    public function inscribirse($idClase)
    {
        $idSocio = auth()->id() ?? 6; // usar el socio logueado (6 para pruebas)

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

            // Verificar si ya tiene reserva
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

      
           // Registrar reserva 
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

    public function metricas()
{
    $idSocio = Auth::id() ?? 6;

    $total = DB::table('reserva')
        ->where('ID_Socio', $idSocio)
        ->where('Estado_Reserva', 'Confirmada')
        ->count();

    $hoy = DB::table('reserva as r')
        ->join('clase_programada as cp', 'r.ID_Clase_Programada', '=', 'cp.ID_Clase_Programada')
        ->where('r.ID_Socio', $idSocio)
        ->where('r.Estado_Reserva', 'Confirmada')
        ->whereDate('cp.Fecha', now()->format('Y-m-d'))
        ->count();

    return response()->json([
        'total' => $total,
        'hoy'   => $hoy
    ]);
}
/**
 * Devuelve las clases en las que el socio está inscripto para mostrar en el calendario.
 */
public function misClasesCalendario()
{
    $idSocio = Auth::id() ?? 6;

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
