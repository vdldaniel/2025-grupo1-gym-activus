<?php

namespace App\Http\Controllers;

use App\Models\TipoMembresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GestionTipoMembresiaController extends Controller
{
    public function index()
    {
        return view('membresias.gestion');
    }

    public function listar()
    {
        $tipos = TipoMembresia::withCount('socios')->get();

        return response()->json([
            'status' => 'success',
            'total_membresias' => $tipos->count(),
            'total_socios' => $tipos->sum('socios_count'),
            'data' => $tipos
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'Nombre_Tipo_Membresia' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('tipo_membresia', 'Nombre_Tipo_Membresia')
                ],
                'Duracion' => 'required|integer|min:1',
                'Unidad_Duracion' => 'required|in:días,semanas,meses,años',
                'Precio' => 'required|numeric|min:0',
                'Descripcion' => 'nullable|string|max:255'
            ],
            [
                'Nombre_Tipo_Membresia.required' => 'Debe ingresar un nombre para la membresía.',
                'Nombre_Tipo_Membresia.max' => 'El nombre puede tener como máximo 100 caracteres.',
                'Nombre_Tipo_Membresia.unique' => 'Ya existe un tipo de membresía con este nombre.',
                'Duracion.required' => 'Debe ingresar la duración.',
                'Duracion.integer' => 'La duración debe ser un número entero.',
                'Duracion.min' => 'La duración debe ser mayor a cero.',
                'Unidad_Duracion.required' => 'Debe indicar la unidad de duración.',
                'Unidad_Duracion.in' => 'Unidad de duración inválida.',
                'Precio.required' => 'Debe ingresar el precio.',
                'Precio.numeric' => 'El precio debe ser un número.',
                'Precio.min' => 'El precio debe ser mayor o igual a cero.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $tipo = TipoMembresia::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Membresía creada correctamente',
            'data' => $tipo
        ], 201);
    }

    public function show($id)
    {
        $tipo = TipoMembresia::find($id);

        if (!$tipo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipo de membresía no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tipo
        ]);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoMembresia::find($id);

        if (!$tipo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipo de membresía no encontrado'
            ], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'Nombre_Tipo_Membresia' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('tipo_membresia', 'Nombre_Tipo_Membresia')
                        ->ignore($id, 'ID_Tipo_Membresia')
                ],
                'Duracion' => 'required|integer|min:1',
                'Unidad_Duracion' => 'required|in:días,semanas,meses,años',
                'Precio' => 'required|numeric|min:0',
                'Descripcion' => 'nullable|string|max:255'
            ],
            [
                'Nombre_Tipo_Membresia.required' => 'Debe ingresar un nombre para la membresía.',
                'Nombre_Tipo_Membresia.max' => 'El nombre puede tener como máximo 100 caracteres.',
                'Nombre_Tipo_Membresia.unique' => 'Ya existe un tipo de membresía con este nombre.',
                'Duracion.required' => 'Debe ingresar la duración.',
                'Duracion.integer' => 'La duración debe ser un número entero.',
                'Duracion.min' => 'La duración debe ser mayor a cero.',
                'Unidad_Duracion.required' => 'Debe indicar la unidad de duración.',
                'Unidad_Duracion.in' => 'Unidad de duración inválida.',
                'Precio.required' => 'Debe ingresar el precio.',
                'Precio.numeric' => 'El precio debe ser un número.',
                'Precio.min' => 'El precio debe ser mayor o igual a cero.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $tipo->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Actualizado correctamente'
        ]);
    }

    public function destroy($id)
    {
        $tipo = TipoMembresia::withCount('socios')->find($id);

        if (!$tipo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipo de membresía no encontrado'
            ], 404);
        }

        if ($tipo->socios_count > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede eliminar porque tiene socios asociados.'
            ], 409);
        }

        $tipo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Eliminado correctamente'
        ]);
    }
}
