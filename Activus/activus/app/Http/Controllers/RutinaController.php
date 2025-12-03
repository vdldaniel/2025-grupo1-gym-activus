<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicio;
use App\Models\Musculo;
use App\Models\Equipo;
use App\Models\Rutina;
use App\Models\NivelDificultad;
use Illuminate\Support\Facades\Validator;


class RutinaController extends Controller
{
    public function index()
    {
        $rutinas = Rutina::with('ejercicios')->get();
        $ejercicios = Ejercicio::all();
        $nivelesDificultad = NivelDificultad::all();


        $totalRutinas = Rutina::distinct('ID_Rutina')->count();

        return view('rutinas.index', compact('ejercicios', 'rutinas', 'totalRutinas', 'nivelesDificultad'));
    }

    public function lista(Request $request)
    {
        $query = Rutina::with(['ejercicios', 'nivelDificultad']);

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where(function ($q) use ($busqueda) {
                $q->where('Nombre_Rutina', 'like', "%$busqueda%")
                ->orWhere('Descripcion', 'like', "%$busqueda%");
            });
        }


        if ($request->input('nivelDificultad') && $request->input('nivelDificultad') !== 'aNiveles') {
            $nivel = $request->input('nivelDificultad');
            $query->whereHas('nivelDificultad', function ($q) use ($nivel) {
                $q->where('Nombre_Nivel_Dificultad', $nivel);
            });
        }

        $rutinas = $query->get();
        $nivelesDificultad = NivelDificultad::all(); 

        return view('rutinas.lista', compact('rutinas', 'nivelesDificultad'));
    }

    public function verRutina($id)
    {
        $rutina = Rutina::findOrFail($id);
        $ejercicio = Ejercicio::all();
        $equipos = Equipo::all();
        $musculos = Musculo::all();
        $nivelesDificultad = NivelDificultad::all();
        return view('rutinas.ver', compact('rutina','ejercicio', 'equipos', 'musculos','nivelesDificultad'));
    }


    public function crearRutina(Request $request)
    {
        $idUsuario= 1;
        $nombre = $request->input('nombreRutina');
        $descripcion = $request->input('descripcionRutina');
        $dificultad = $request->input('dificultadRutina');
        $duracion = $request->input('duracionRutina');
        $dias = $request->input('diasRutina');
        $ejercicios = $request->input('ejercicioRutina');
        $series = $request->input('seriesRutina');
        $repeticiones = $request->input('repeticionesRutina');


        $validacion_rutina = Validator::make($request->all(), [
            'nombreRutina' => ['required', 'string', 'max:100', 'min:2'],
            'descripcionRutina' => ['required', 'string', 'max:255', 'min:5'],
            'ejercicioRutina' => ['required', 'array'],
            'ejercicioRutina.*' => ['exists:ejercicio,ID_Ejercicio'],
            'seriesRutina' => ['array'],
            'seriesRutina.*' => ['required', 'numeric', 'min:1'],
            'repeticionesRutina' => ['array'],
            'repeticionesRutina.*' => ['required', 'numeric', 'min:1'],
            'dificultadRutina' => ['exists:nivel_dificultad,ID_Nivel_Dificultad'],
            'duracionRutina' => ['required', 'integer', 'min:1'],
            'diasRutina' => ['required', 'string'],

        ], [
            'nombreRutina.required' => 'Nombre no ingresado',
            'nombreRutina.max' => 'El nombre debe tener menos de 100 carácteres',
            'nombreRutina.min' => 'El nombre debe tener más de 2 carácteres',
            'descripcionRutina.required' => 'Descripción no ingresada',
            'descripcionRutina.max' => 'La descripción debe tener menos de 255 carácteres',
            'descripcionRutina.min' => 'La descripción debe tener más de 5 carácteres',
        ]);

        if ($validacion_rutina->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validacion_rutina->errors(),
            ], 422);
        }

        try {


            $rutina = Rutina::create([
                "ID_Profesor" => $idUsuario,
                "Nombre_Rutina" => $nombre,
                "Descripcion" => $descripcion,
                "ID_Nivel_Dificultad" => $dificultad,
                "Duracion_Aprox" => $duracion,
                "Cant_Dias_Semana" => $dias,
            ]);

            foreach ($ejercicios as $index => $idEjercicio) {
                $rutina->ejercicios()->attach($idEjercicio, [
                    'Series' => $series[$index],
                    'Repeticiones' => $repeticiones[$index],
                ]);
            }



            return response()->json([
                'success' => true,
                'message' => "Rutina creada correctamente",
                'rutina' => $rutina,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

public function editarRutina(Request $request, $id)
{
    $nombre = $request->input('nombreRutinaEditar');
    $descripcion = $request->input('descripcionRutinaEditar');
    $dificultad = $request->input('dificultadRutinaEditar');
    $duracion = $request->input('duracionRutinaEditar');
    $dias = $request->input('diasRutinaEditar');
    $ejercicios = $request->input('ejercicioRutinaEditar');
    $series = $request->input('seriesRutinaEditar');
    $repeticiones = $request->input('repeticionesRutinaEditar');

    $validacion_rutina = Validator::make($request->all(), [
        'nombreRutinaEditar' => ['required', 'string', 'max:100', 'min:2'],
        'descripcionRutinaEditar' => ['required', 'string', 'max:255', 'min:5'],
        'ejercicioRutinaEditar' => ['required', 'array'],
        'ejercicioRutinaEditar.*' => ['exists:Ejercicio,ID_Ejercicio'],
        'seriesRutinaEditar.*' => ['required', 'numeric', 'min:1'],
        'repeticionesRutinaEditar.*' => ['required', 'numeric', 'min:1'],
        'dificultadRutinaEditar' => ['exists:Nivel_Dificultad,ID_Nivel_Dificultad'],
        'duracionRutinaEditar' => ['required', 'integer', 'min:1'],
        'diasRutinaEditar' => ['required', 'string'],
    ]);

    if ($validacion_rutina->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validacion_rutina->errors(),
        ], 422);
    }

    try {
        $rutina = Rutina::findOrFail($id);

        $rutina->update([
            "Nombre_Rutina" => $nombre,
            "Descripcion" => $descripcion,
            "ID_Nivel_Dificultad" => $dificultad,
            "Duracion_Aprox" => $duracion,
            "Cant_Dias_Semana" => $dias,
        ]);

        $pivotData = [];
        foreach ($ejercicios as $index => $ejercicioId) {
            $pivotData[$ejercicioId] = [
                'Series' => $series[$index] ?? 0,
                'Repeticiones' => $repeticiones[$index] ?? 0
            ];
        }
        $rutina->ejercicios()->sync($pivotData);

        return response()->json([
            'success' => true,
            'message' => "Rutina actualizada correctamente",
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

    public function eliminarRutina($id)
    {
        $rutina = Rutina::find($id);

        if (!$rutina) {
            return redirect()->back()->with('error', 'Rutina no encontrada.');
        }

        try {
            $rutina->ejercicios()->detach();
            $rutina->delete();

            return redirect()->back()->with('success', 'Rutina eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la rutina: ' . $e->getMessage());
        }
    }

}
