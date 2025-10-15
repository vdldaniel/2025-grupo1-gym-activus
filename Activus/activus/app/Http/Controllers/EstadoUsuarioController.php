<?php

namespace App\Http\Controllers;

use App\Models\EstadoUsuario;
use Illuminate\Http\Request;

class EstadoUsuarioController extends Controller
{
    public function index()
    {
        $estadosUsuario = EstadoUsuario::all();
        return view('usuarios.index', compact('estadosUsuario'));
    }
}
