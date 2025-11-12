<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\ClaseProgramada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    //listar todas las clases con el profesor y capacidad maxima
    public function listar()
    {

        $user = Auth::user();

        $query = Clase::with('profesor');

        // si es profe envia solo sus clases 
        $rolesUsuario = $user->roles()->pluck('Nombre_Rol')->toArray();

        if (in_array('Profesor', $rolesUsuario)) {
            $query->where('ID_Profesor', $user->ID_Usuario);
        }

        $clases = $query->get()->map(function ($item) {
            return [
                'id' => $item->ID_Clase,
                'nombre_clase' => $item->Nombre_Clase ?? 'Sin nombre',
                'profesor' => $item->profesor->Nombre ?? '—',
                'capacidad' => $item->Capacidad_Maxima ?? 0,
            ];
        });

        return response()->json($clases);



        /*$clases = Clase::with('profesor')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->ID_Clase,
                    'nombre_clase' => $item->Nombre_Clase ?? 'Sin nombre',
                    'profesor' => $item->profesor->Nombre ?? '—',
                    'capacidad' => $item->Capacidad_Maxima ?? 0,
                ];
            });

        return response()->json($clases);*/
    }

    //total de clases , cantidad de clases programadas para el dia actual
    public function obtenerMetricas()
    {
        $user = Auth::user();
        $rolesUsuario = $user->roles()->pluck('Nombre_Rol')->toArray();


        $claseQuery = Clase::query();
        $claseProgQuery = ClaseProgramada::query();


        $esProfesor = in_array('Profesor', $rolesUsuario);

        if ($esProfesor) {
            $claseQuery->where('ID_Profesor', $user->ID_Usuario);
            $claseProgQuery->whereHas('clase', function ($q) use ($user) {
                $q->where('ID_Profesor', $user->ID_Usuario);
            });
        }

        $totalClases = $claseQuery->count();

        $clasesHoy = $claseProgQuery
            ->whereDate('Fecha', now()->toDateString())
            ->count();

        return response()->json([
            'ok' => true,
            'totalClases' => $totalClases,
            'clasesHoy' => $clasesHoy,
        ]);

        /*$totalClases = Clase::count();
        $clasesHoy = ClaseProgramada::whereDate('Fecha', now()->toDateString())->count();
        return response()->json([
            'ok' => true,
            'totalClases' => $totalClases,
            'clasesHoy' => $clasesHoy,
        ]);*/
    }

    public function guardar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'NombreClase' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'Profesor' => [
                    'required',
                    'integer',
                    Rule::exists('usuario', 'ID_Usuario')
                ],
                'Capacidad' => 'required|integer|min:1',
            ],
            [
                'NombreClase.required' => 'Debe ingresar un nombre para la clase.',
                'NombreClase.max' => 'El nombre puede tener como máximo 100 caracteres.',
                'Profesor.required' => 'Debe seleccionar un profesor.',
                'Profesor.exists' => 'El profesor seleccionado no existe.',
                'Capacidad.required' => 'Debe ingresar la capacidad máxima.',
                'Capacidad.integer' => 'La capacidad debe ser un número entero.',
                'Capacidad.min' => 'La capacidad debe ser al menos 1.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $clase = Clase::create([
            'Nombre_Clase' => $request->NombreClase,
            'ID_Profesor' => $request->Profesor,
            'Capacidad_Maxima' => $request->Capacidad,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Clase creada correctamente',
            'data' => $clase
        ], 201);
    }

    public function show($id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Clase no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $clase
        ]);
    }




    public function obtener($id)
    {
        $clase = Clase::with([
            'profesor' => function ($q) {
                $q->select('ID_Usuario', 'Nombre', 'Apellido', 'ID_Estado_Usuario');
            }
        ])->find($id);

        if (!$clase) {
            return response()->json(['ok' => false, 'mensaje' => 'Clase no encontrada.'], 404);
        }

        $profesor = $clase->profesor;

        return response()->json([
            'ok' => true,
            'clase' => [
                'ID_Clase' => $clase->ID_Clase,
                'Nombre_Clase' => $clase->Nombre_Clase ?? '',
                'ID_Profesor' => $profesor->ID_Usuario ?? null,
                'Nombre_Profesor' => trim(($profesor->Nombre ?? '') . ' ' . ($profesor->Apellido ?? '')) ?: 'Sin nombre',
                'Capacidad_Maxima' => $clase->Capacidad_Maxima ?? 0,
                'Estado_Profesor' => $profesor->estadoUsuario->Nombre_Estado_Usuario ?? null,
            ]
        ]);
    }


    public function actualizar(Request $request, $id)
    {

        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Clase no encontrada'
            ], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'NombreClase' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'Profesor' => [
                    'required',
                    'integer',
                    Rule::exists('usuario', 'ID_Usuario')
                ],
                'Capacidad' => 'required|integer|min:1',
            ],
            [
                'NombreClase.required' => 'Debe ingresar un nombre para la clase.',
                'NombreClase.max' => 'El nombre puede tener como máximo 100 caracteres.',
                'Profesor.required' => 'Debe seleccionar un profesor.',
                'Profesor.exists' => 'El profesor seleccionado no existe.',
                'Capacidad.required' => 'Debe ingresar la capacidad máxima.',
                'Capacidad.integer' => 'La capacidad debe ser un número entero.',
                'Capacidad.min' => 'La capacidad debe ser al menos 1.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $clase->update([
            'Nombre_Clase' => $request->NombreClase,
            'ID_Profesor' => $request->Profesor,
            'Capacidad_Maxima' => $request->Capacidad,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Clase actualizada correctamente',
            'data' => $clase
        ]);

    }

    public function eliminar($id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['ok' => false, 'mensaje' => 'Clase no encontrada.'], 404);
        }

        $clase->delete();

        return response()->json(['ok' => true, 'mensaje' => 'Clase eliminada correctamente.']);
    }

}
