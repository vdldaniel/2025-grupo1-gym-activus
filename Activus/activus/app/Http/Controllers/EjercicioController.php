<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\Musculo;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EjercicioController extends Controller
{
    public function index()
    {
        $ejercicios = Ejercicio::all();
        $equipos = Equipo::all();
        $musculos = Musculo::all();

        $totalEjercicios = Ejercicio::distinct('ID_Ejercicio')->count();
        $totalEquipos = Equipo::distinct('ID_Equipo')->count();
        $totalMusculos = Musculo::distinct('ID_Musculo')->count();

        return view('ejercicios.index', compact('ejercicios', 'equipos', 'musculos', 'totalEjercicios', 'totalEquipos', 'totalMusculos'));
    }

    public function gestion()
    {
        $ejercicios = Ejercicio::with(['musculos', 'equipos'])->get();
        return view('ejercicios.gestion', compact('ejercicios'));
    }

    public function lista(Request $request)
    {
        $query = Ejercicio::with(['musculos', 'equipos']);

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where(function ($q) use ($busqueda) {
                $q->where('Nombre_Ejercicio', 'like', "%$busqueda%")
                ->orWhere('Descripcion', 'like', "%$busqueda%");
            });
        }

        if ($request->input('musculo') && $request->input('musculo') !== 'aMusculos') {
            $musculo = $request->input('musculo');
            $query->whereHas('musculos', function ($q) use ($musculo) {
                $q->where('Nombre_Musculo', $musculo);
            });
        }

        if ($request->input('equipo') && $request->input('equipo') !== 'aEquipos') {
            $equipo = $request->input('equipo');
            $query->whereHas('equipos', function ($q) use ($equipo) {
                $q->where('Nombre_Equipo', $equipo);
            });
        }

        $ejercicios = $query->get();

        return view('ejercicios.lista', compact('ejercicios'));
    }



    public function crearEjercicio(Request $request)
    {
        $nombre = $request->input('nombreEjercicio');
        $descripcion = $request->input('descripcionEjercicio');
        $musculos = $request->input('musculos');
        $equipos = $request->input('equipos');
        $instrucciones = $request->input('instrucciones');
        $tips = $request->input('tips');


        $validacion_ejercicio = Validator::make($request->all(), [
            'nombreEjercicio' => ['required', 'string', 'max:100', 'min:2'],
            'descripcionEjercicio' => ['required', 'string', 'max:255', 'min:5'],
            'musculos' => ['required', 'array'],
            'musculos.*' => ['exists:musculo,ID_Musculo'],
            'equipos' => ['array'],
            'equipos.*' => ['exists:equipo,ID_Equipo'],
            'instrucciones' => ['required', 'string', 'max:500', 'min:10'],
            'tips' => ['nullable', 'string', 'max:255'],
        ], [
            'nombreEjercicio.required' => 'Nombre no ingresado',
            'nombreEjercicio.max' => 'El nombre debe tener menos de 100 carácteres',
            'nombreEjercicio.min' => 'El nombre debe tener más de 2 carácteres',
            'descripcionEjercicio.required' => 'Descripción no ingresada',
            'descripcionEjercicio.max' => 'La descripción debe tener menos de 255 carácteres',
            'descripcionEjercicio.min' => 'La descripción debe tener más de 5 carácteres',
        ]);

        if ($validacion_ejercicio->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validacion_ejercicio->errors(),
            ], 422);
        }



        try {


            $ejercicio = Ejercicio::create([
                "Nombre_Ejercicio" => $nombre,
                "Descripcion" => $descripcion,
                "Instrucciones" => $instrucciones,
                "Tips" => $tips,
            ]);

            $ejercicio->musculos()->attach($musculos);

            if (!empty($equipos)) {
                $ejercicio->equipos()->attach($equipos);
            }


            return response()->json([
                'success' => true,
                'message' => "Ejercicio creado correctamente",
                'ejercicio' => $ejercicio,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function editarEjercicio(Request $request, $id)
{
    $validacion_ejercicio = Validator::make($request->all(), [
        'nombreEjercicio' => ['required', 'string', 'max:100', 'min:2'],
        'descripcionEjercicio' => ['required', 'string', 'max:255', 'min:5'],
        'musculos' => ['required', 'array'],
        'musculos.*' => ['exists:musculo,ID_Musculo'],
        'equipos' => ['array'],
        'equipos.*' => ['exists:equipo,ID_Equipo'],
        'instrucciones' => ['required', 'string', 'max:500', 'min:10'],
        'tips' => ['nullable', 'string', 'max:255'],
    ]);

    if ($validacion_ejercicio->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validacion_ejercicio->errors(),
        ], 422);
    }

    try {
    
        $ejercicio = Ejercicio::findOrFail($id);

        
        $ejercicio->update([
            "Nombre_Ejercicio" => $request->nombreEjercicio,
            "Descripcion" => $request->descripcionEjercicio,
            "Instrucciones" => $request->instrucciones,
            "Tips" => $request->tips,
        ]);

        
        $ejercicio->musculos()->sync($request->musculos);
        $ejercicio->equipos()->sync($request->equipos ?? []);

        return response()->json([
            'success' => true,
            'message' => "Ejercicio actualizado correctamente",
            'ejercicio' => $ejercicio,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}



    public function eliminarEjercicio($id)
    {
        $ejercicio = Ejercicio::find($id);

        if (!$ejercicio) {
            return redirect()->back()->with('error', 'Ejercicio no encontrado.');
        }

        try {
            $ejercicio->musculos()->detach();
            $ejercicio->equipos()->detach();
            $ejercicio->delete();

            return redirect()->back()->with('success', 'Ejercicio eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el ejercicio: ' . $e->getMessage());
        }
    }




}


