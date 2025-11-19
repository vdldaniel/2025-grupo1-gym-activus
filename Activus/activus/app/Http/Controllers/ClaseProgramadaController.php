<?php

namespace App\Http\Controllers;

use App\Models\ClaseProgramada;
use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClaseProgramadaController extends Controller
{
    public function obtenerEventos()
    {


        $user = Auth::user();

        $query = ClaseProgramada::with('clase');


        $rolesUsuario = $user->roles()->pluck('Nombre_Rol')->toArray();

        if (in_array('Profesor', $rolesUsuario)) {
            // Si es profesor solo sus clases
            $query->whereHas('clase', function ($q) use ($user) {
                $q->where('ID_Profesor', $user->ID_Usuario);
            });
        }


        $eventos = $query->get()->map(function ($item) {
            return [
                'title' => $item->clase->Nombre_Clase ?? 'Clase sin nombre',
                'start' => $item->Fecha . 'T' . $item->Hora_Inicio,
                'end' => $item->Fecha . 'T' . $item->Hora_Fin,
            ];
        });

        return response()->json($eventos);
        /* $eventos = ClaseProgramada::with('clase')
             ->get()
             ->map(function ($item) {
                 return [
                     'title' => $item->clase->Nombre_Clase ?? 'Clase sin nombre',
                     'start' => $item->Fecha . 'T' . $item->Hora_Inicio,
                     'end' => $item->Fecha . 'T' . $item->Hora_Fin,
                 ];
             });

         return response()->json($eventos);*/
    }



    public function listar()
    {

        $user = Auth::user();
        $rolesUsuario = $user->roles()->pluck('Nombre_Rol')->toArray();

        $query = ClaseProgramada::with(['clase.profesor', 'sala']);


        if (in_array('Profesor', $rolesUsuario)) {
            $query->whereHas('clase', function ($q) use ($user) {
                $q->where('ID_Profesor', $user->ID_Usuario);
            });
        }

        $clasesProgramadas = $query->get()->map(function ($item) {
            $inscriptos = Reserva::where('ID_Clase_Programada', $item->ID_Clase_Programada)
                ->where('Estado_Reserva', 'Confirmada')
                ->count();

            $capacidadTotal = $item->clase->Capacidad_Maxima ?? 0;

            return [
                'id' => $item->ID_Clase_Programada,
                'nombre_clase' => $item->clase->Nombre_Clase ?? 'Sin nombre',
                'profesor' => $item->clase->profesor->Nombre ?? '—',
                'capacidad' => "{$inscriptos} / {$capacidadTotal}",
                'sala' => $item->sala->Nombre_Sala ?? '—',
                'fecha' => $item->Fecha,
                'hora_inicio' => Carbon::parse($item->Hora_Inicio)->format('H:i'),
                'hora_fin' => Carbon::parse($item->Hora_Fin)->format('H:i'),
            ];
        });

        return response()->json($clasesProgramadas);
        /* $clasesProgramadas = ClaseProgramada::with(['clase.profesor', 'clase', 'sala'])
             ->get()
             ->map(function ($item) {

                 // cantidad de reservas estado=confirmada === inscriptos
                 $inscriptos = Reserva::where('ID_Clase_Programada', $item->ID_Clase_Programada)
                     ->where('Estado_Reserva', 'Confirmada')
                     ->count();

                 $capacidadTotal = $item->clase->Capacidad_Maxima ?? 0;

                 return [
                     'id' => $item->ID_Clase_Programada,
                     'nombre_clase' => $item->clase->Nombre_Clase ?? 'Sin nombre',
                     'profesor' => $item->clase->profesor->Nombre ?? '—',
                     'capacidad' => "{$inscriptos} / {$capacidadTotal}",
                     'sala' => $item->sala->Nombre_Sala ?? '—',
                     'fecha' => $item->Fecha,
                     'hora_inicio' => \Carbon\Carbon::parse($item->Hora_Inicio)->format('H:i'),
                     'hora_fin' => \Carbon\Carbon::parse($item->Hora_Fin)->format('H:i'),
                 ];
             });

         return response()->json($clasesProgramadas);*/
    }



    public function eliminar($id)
    {
        try {
            $claseProgramada = ClaseProgramada::find($id);

            if (!$claseProgramada) {
                return response()->json([
                    'ok' => false,
                    'mensaje' => 'La clase programada no existe.'
                ], 404);
            }
            /// no perimite eliminar si tiene reservas activas
            $tieneReservasConfirmadas = Reserva::where('ID_Clase_Programada', $id)
                ->where('Estado_Reserva', 'Confirmada')
                ->exists();

            if ($tieneReservasConfirmadas) {
                return response()->json([
                    'ok' => false,
                    'mensaje' => 'No se puede eliminar la clase programada porque tiene reservas confirmadas.'
                ], 400);
            }

            $claseProgramada->delete();

            return response()->json([
                'ok' => true,
                'mensaje' => 'Clase programada eliminada correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'Error al eliminar la clase programada: ' . $e->getMessage()
            ], 500);
        }
    }
    public function obtener($id)
    {
        $claseProgramada = ClaseProgramada::with(['clase', 'sala'])->find($id);

        if (!$claseProgramada) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'Clase programada no encontrada.'
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'claseProgramada' => [
                'ID_Clase_Programada' => $claseProgramada->ID_Clase_Programada,
                'ID_Clase' => $claseProgramada->ID_Clase,
                'Nombre_Clase' => $claseProgramada->clase->Nombre_Clase ?? 'Sin nombre',
                'ID_Sala' => $claseProgramada->ID_Sala,
                'Nombre_Sala' => $claseProgramada->sala->Nombre_Sala ?? '—',
                'Fecha' => $claseProgramada->Fecha,
                'Hora_Inicio' => $claseProgramada->Hora_Inicio,
                'Hora_Fin' => $claseProgramada->Hora_Fin,
            ]
        ]);
    }




    public function guardar(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ID_Clase' => 'required|exists:clase,ID_Clase',
            'ID_Sala' => 'required|exists:sala,ID_Sala',
            'Fecha' => 'required|date|after_or_equal:today',
            'Hora_Inicio' => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'Hora_Fin' => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/|after:Hora_Inicio',
        ], [
            'ID_Clase.required' => 'Debe seleccionar una clase.',
            'ID_Clase.exists' => 'La clase seleccionada no existe.',
            'ID_Sala.required' => 'Debe seleccionar una sala.',
            'ID_Sala.exists' => 'La sala seleccionada no existe.',
            'Fecha.required' => 'Debe ingresar una fecha.',
            'Fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'Hora_Inicio.required' => 'Debe ingresar una hora de inicio.',
            'Hora_Fin.required' => 'Debe ingresar una hora de fin.',
            'Hora_Fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $horaInicio = strlen($request->Hora_Inicio) === 5 ? $request->Hora_Inicio . ':00' : $request->Hora_Inicio;
        $horaFin = strlen($request->Hora_Fin) === 5 ? $request->Hora_Fin . ':00' : $request->Hora_Fin;


        // NO PERMITE USAR LA MISMA SALA EN EL MISMO HORARIO
        $solapada = ClaseProgramada::where('ID_Sala', $request->ID_Sala)
            ->where('Fecha', $request->Fecha)
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('Hora_Inicio', [$horaInicio, $horaFin])
                    ->orWhereBetween('Hora_Fin', [$horaInicio, $horaFin])
                    ->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                        $q2->where('Hora_Inicio', '<=', $horaInicio)
                            ->where('Hora_Fin', '>=', $horaFin);
                    });
            })
            ->exists();

        if ($solapada) {
            return response()->json([
                'errors' => [
                    'ID_Sala' => ['La sala ya está ocupada en ese horario.']
                ]
            ], 422);
        }


        ClaseProgramada::create([
            'ID_Clase' => $request->ID_Clase,
            'ID_Sala' => $request->ID_Sala,
            'Fecha' => $request->Fecha,
            'Hora_Inicio' => $horaInicio,
            'Hora_Fin' => $horaFin,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Clase programada creada exitosamente.'
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $claseProg = ClaseProgramada::find($id);

        if (!$claseProg) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontró la clase programada.'
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'ID_Clase' => 'required|exists:clase,ID_Clase',
            'ID_Sala' => 'required|exists:sala,ID_Sala',
            'Fecha' => 'required|date|after_or_equal:today',
            'Hora_Inicio' => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'Hora_Fin' => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/|after:Hora_Inicio',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $horaInicio = strlen($request->Hora_Inicio) === 5 ? $request->Hora_Inicio . ':00' : $request->Hora_Inicio;
        $horaFin = strlen($request->Hora_Fin) === 5 ? $request->Hora_Fin . ':00' : $request->Hora_Fin;

        // NO PERMITE USAR LA MISSMA SALA EN EL MISMO HORARIO
        $solapada = ClaseProgramada::where('ID_Sala', $request->ID_Sala)
            ->where('Fecha', $request->Fecha)
            ->where('ID_Clase_Programada', '!=', $id)
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('Hora_Inicio', [$horaInicio, $horaFin])
                    ->orWhereBetween('Hora_Fin', [$horaInicio, $horaFin])
                    ->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                        $q2->where('Hora_Inicio', '<=', $horaInicio)
                            ->where('Hora_Fin', '>=', $horaFin);
                    });
            })
            ->exists();

        if ($solapada) {
            return response()->json([
                'errors' => [
                    'ID_Sala' => ['La sala ya está ocupada en ese horario.']
                ]
            ], 422);
        }


        $claseProg->update([
            'ID_Clase' => $request->ID_Clase,
            'ID_Sala' => $request->ID_Sala,
            'Fecha' => $request->Fecha,
            'Hora_Inicio' => $horaInicio,
            'Hora_Fin' => $horaFin,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Clase programada actualizada correctamente.'
        ]);
    }

    public function obtenerAlumnos($id)
    {
        $alumnos = Reserva::with('usuario')
            ->where('ID_Clase_Programada', $id)
            ->where('Estado_Reserva', 'Confirmada')
            ->get()
            ->map(fn($r) => [
                'nombre' => trim($r->usuario->Nombre . ' ' . $r->usuario->Apellido)
            ]);

        return response()->json($alumnos);
    }




}

