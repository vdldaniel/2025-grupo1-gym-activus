<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoMembresia;

class TipoMembresiaController extends Controller
{
    public function obtenerMembresias()
    {
        $membresias = TipoMembresia::all();
        return response()->json($membresias);
    }
    

    public function index()
    {
        $membresias = TipoMembresia::all();
        return view('socios.index', compact('membresias'));
    }


}
