<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

class EquipoController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->query('eq');

        if (!$query) {
            return response()->json([]);
        }

        $equipos = Equipo::where('Nombre_Equipo', 'LIKE', '%' . $query . '%')
            ->select('ID_Equipo', 'Nombre_Equipo')
            ->take(5)
            ->get();

        return response()->json($equipos);
    }
}
