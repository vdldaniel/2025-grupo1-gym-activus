<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SalaController extends Controller
{
    public function index()
    {

        return view('salas.index');
    }

    public function listar()
    {

        $salas = Sala::all();
        return response()->json($salas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'NombreSala' => [
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                    Rule::unique('sala', 'Nombre_Sala')
                ]
            ],
            [
                'NombreSala.required' => 'Debe ingresar un nombre.',
                'NombreSala.unique' => 'Ya existe una sala con ese nombre.',
                'NombreSala.min' => 'El nombre debe tener al menos 2 caracteres.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $sala = Sala::create([
            'Nombre_Sala' => $request->NombreSala,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sala creada correctamente',
            'sala' => $sala
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'NombreSala' => [
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                    Rule::unique('sala', 'Nombre_Sala')->ignore($id, 'ID_Sala')
                ]
            ],
            [
                'NombreSala.required' => 'Debe ingresar un nombre.',
                'NombreSala.unique' => 'Ya existe una sala con ese nombre.',
                'NombreSala.min' => 'El nombre debe tener al menos 2 caracteres.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $sala = Sala::findOrFail($id);
        $sala->update(['Nombre_Sala' => $request->NombreSala]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sala actualizada correctamente'
        ]);
    }

    public function destroy($id)
    {
        $sala = Sala::findOrFail($id);
        $sala->delete();

        return response()->json(['success' => true]);
    }
}
