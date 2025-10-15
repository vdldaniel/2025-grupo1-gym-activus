<?php

namespace App\Http\Controllers;

use App\Models\Rol;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::whereIn('ID_Rol', [1, 2, 3])->get(); //*Solo admin,profesor y administrativo
        return view('usuarios.index', compact('roles'));
    }

}
