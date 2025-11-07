<?php

namespace App\Http\Controllers;

use App\Models\ClaseProgramada;
use Illuminate\Http\Request;

class ClaseProgramadaController extends Controller
{
    public function obtenerEventos()
    {

        $eventos = ClaseProgramada::with('clase')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->clase->Nombre_Clase ?? 'Clase sin nombre',
                    'start' => $item->Fecha . 'T' . $item->Hora_Inicio,
                    'end' => $item->Fecha . 'T' . $item->Hora_Fin,
                ];
            });

        return response()->json($eventos);
    }
}
