<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = \App\Models\Usuario::where('Email', $request->email)->first();

        if (!$usuario) {
            return back()->with('error', 'El usuario no existe.');
        }

        // Compara hash o texto plano
        $passwordOk = \Illuminate\Support\Facades\Hash::check($request->password, $usuario->Contrasena)
            || $usuario->Contrasena === $request->password;

        if ($passwordOk) {

            Auth::login($usuario);
            $request->session()->regenerate();
            return redirect()->intended('/')->with('status', 'Sesión iniciada ✅');
        }

        return back()->with('error', 'Las credenciales no son válidas.');
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        // Invalida toda la sesión actual
        $request->session()->invalidate();

        // Regenera el token CSRF
        $request->session()->regenerateToken();

        // Redirige al login
        return redirect('/')->with('status', 'Sesión cerrada correctamente ✅');
    }
}
