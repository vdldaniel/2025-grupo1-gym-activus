<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InicioAdministradorController extends Controller
{
    /**
     * Muestra la vista principal del administrador.
     */
    public function index()
    {
        return view('inicio.administrador');
    }

    /**
     * Devuelve los datos del dashboard del administrador.
     */
    public function datos()
    {
        try {
            // Total de usuarios registrados en el gimnasio
            $totalUsuarios = DB::table('usuario')->count();

            // Respuesta JSON
            return response()->json([
                'success' => true,
                'data' => [
                    'totalUsuarios' => $totalUsuarios,
                    'descripcion' => 'Usuarios registrados en este gimnasio'
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
