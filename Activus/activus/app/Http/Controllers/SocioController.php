<?php

namespace App\Http\Controllers;

use App\Models\Socio;

class SocioController extends Controller
{
    public function index () {
        $socios = Socio::all();
        return view("socios.index");
    }
}
