<?php

namespace App\Http\Controllers;

use App\Models\MembresiaSocio;
use Illuminate\Http\Request;
use App\Models\EstadoMembresiaSocio;

class MembresiaSocioController extends Controller
{
    public function index()
    {
        $membresiasSocio = MembresiaSocio::all();
        $estadosMembresiaSocio = EstadoMembresiaSocio::all();


        return view('socios.index', compact('membresiasSocio', 'estadosMembresiaSocio'));
    }
}
