<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NivelDificultad;

class NivelDificultadController extends Controller
{
    public function index()
    {
        $nivelesDificultad = NivelDificultad::all();
        return view('rutinas.index', compact('nivelesDificultad'));
    }
}
