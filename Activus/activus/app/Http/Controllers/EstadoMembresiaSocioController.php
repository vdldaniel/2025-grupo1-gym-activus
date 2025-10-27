<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstadoMembresiaSocio;

class EstadoMembresiaSocioController extends Controller
{
    public function index()
    {
        $estadosMembresiaSocio = EstadoMembresiaSocio::all();
        return view('socios.index', compact('estadosMembresiaSocio'));
    }
}
