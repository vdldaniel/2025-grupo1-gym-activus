<?php

namespace App\Http\Controllers;

use App\Models\EstadoUsuario;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::whereHas('roles', function ($query) {
            $query->whereIn('rol.ID_Rol', [1, 2, 3]);
        })->get();


        $roles = Rol::whereIn('rol.ID_Rol', [1, 2, 3])->get();
        $estadosUsuario = EstadoUsuario::all();

        $totalUsuarios = Usuario::distinct('ID_Usuario')->count();

        $totalUsuariosInternos = Usuario::whereHas('roles', function ($q) {
            $q->whereIn('Nombre_Rol', ['Administrador', 'Administrativo', 'Profesor']);
        })->distinct('ID_Usuario')->count();

        $totalAdmins = Usuario::conRol('Administrador')->distinct('ID_Usuario')->count();
        $totalAdministrativos = Usuario::conRol('Administrativo')->distinct('ID_Usuario')->count();
        $totalProfesores = Usuario::conRol('Profesor')->distinct('ID_Usuario')->count();

        return view('usuarios.index', compact('usuarios', 'roles', 'estadosUsuario', 'totalUsuarios', 'totalUsuariosInternos', 'totalAdministrativos', 'totalAdmins', 'totalProfesores'));
    }


    public function crearUsuario(Request $request)
    {
        $nombre = $request->input('nombreUsuario');
        $apellido = $request->input('apellidoUsuario');
        $dni = $request->input('dniUsuario');
        $telefono = $request->input('telefonoUsuario');
        $email = $request->input('emailUsuario');
        $rol = $request->input('rolUsuario');
        $path = 'images/default/profile-default.jpg';


        $validacion_usuario = Validator::make($request->all(), [
            'nombreUsuario' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'apellidoUsuario' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'dniUsuario' => ['required', 'digits:8', 'unique:usuario,dni', 'regex:/^[0-9]+$/'],
            'telefonoUsuario' => ['required', 'digits:10', 'unique:usuario,telefono', 'regex:/^[0-9]+$/'],
            'emailUsuario' => ['required', 'email', 'unique:usuario,Email'],
            'rolUsuario' => ['required', 'exists:rol,ID_Rol'],
        ], [
            'nombreUsuario.required' => 'Nombre no ingresado',
            'nombreUsuario.max' => 'El nombre debe tener menos de 50 carácteres',
            'nombreUsuario.min' => 'El nombre debe tener más de 2 carácteres',
            'nombreUsuario.regex' => 'El nombre solo puede contener letras y espacios',
            'apellidoUsuario.regex' => 'El apellido solo puede contener letras y espacios',
            'apellidoUsuario.required' => 'Apellido no ingresado',
            'apellidoUsuario.max' => 'El apellido debe tener menos de 50 carácteres',
            'apellidoUsuario.min' => 'El apellido debe tener más de 2 carácteres',
            'dniUsuario.regex' => 'El DNI solo puede contener números',
            'dniUsuario.required' => 'DNI no ingresado',
            'dniUsuario.unique' => 'DNI ya registrado',
            'dniUsuario.digits' => 'DNI debe tener exactamente 8 números',
            'telefonoUsuario.required' => 'Teléfono no ingresado',
            'telefonoUsuario.unique' => 'Teléfono ya registrado',
            'telefonoUsuario.digits' => 'Teléfono debe tener exactamente 10 números',
            'emailUsuario.required' => 'Email no ingresado',
            'emailUsuario.email' => 'Email no válido',
            'emailUsuario.unique' => 'El email ya está registrado',
            'rolUsuario.required' => 'Rol no seleccionado',
            'rolUsuario.exists' => 'El rol seleccionado no existe',
        ]);

        if ($validacion_usuario->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validacion_usuario->errors(),
            ], 422);
        }



        try {

            $usuario = Usuario::create([
                "Nombre" => $nombre,
                "Apellido" => $apellido,
                "DNI" => $dni,
                "Telefono" => $telefono,
                "Email" => $email,
                "Foto_Perfil" => $path,
                "ID_Estado_Usuario" => 1,
                "Contrasena" => bcrypt($dni),
                "Fecha_Alta" => now(),
            ]);


            $usuario->roles()->sync($rol);

            return response()->json([
                'success' => true,
                'message' => "Usuario creado correctamente",
                'usuario' => $usuario->load('roles'),
            ], 200);



        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function editarUsuario(Request $request, $id)
    {
        $nombre = $request->input('nombreUsuarioEditar');
        $apellido = $request->input('apellidoUsuarioEditar');
        $dni = $request->input('dniUsuarioEditar');
        $telefono = $request->input('telefonoUsuarioEditar');
        $email = $request->input('emailUsuarioEditar');
        $rol = $request->input('rolUsuarioEditar');

        $validacion_usuario = Validator::make($request->all(), [
            'nombreUsuarioEditar' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'apellidoUsuarioEditar' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'dniUsuarioEditar' => ['required', 'digits:8', 'regex:/^[0-9]+$/', Rule::unique('usuario', 'DNI')->ignore($id, 'ID_Usuario'),],
            'telefonoUsuarioEditar' => ['required', 'digits:10', 'regex:/^[0-9]+$/', Rule::unique('usuario', 'Telefono')->ignore($id, 'ID_Usuario')],
            'emailUsuarioEditar' => ['required', 'email', Rule::unique('usuario', 'Email')->ignore($id, 'ID_Usuario'),],
            'rolUsuarioEditar' => ['required', 'exists:rol,ID_Rol'],
        ], [
            'nombreUsuarioEditar.required' => 'Nombre no ingresado',
            'nombreUsuarioEditar.max' => 'El nombre debe tener menos de 50 carácteres',
            'nombreUsuarioEditar.min' => 'El nombre debe tener más de 2 carácteres',
            'nombreUsuarioEditar.regex' => 'El nombre solo puede contener letras y espacios',
            'apellidoUsuarioEditar.regex' => 'El apellido solo puede contener letras y espacios',
            'apellidoUsuarioEditar.required' => 'Apellido no ingresado',
            'apellidoUsuarioEditar.max' => 'El apellido debe tener menos de 50 carácteres',
            'apellidoUsuarioEditar.min' => 'El apellido debe tener más de 2 carácteres',
            'dniUsuarioEditar.regex' => 'El DNI solo puede contener números',
            'dniUsuarioEditar.required' => 'DNI no ingresado',
            'dniUsuarioEditar.unique' => 'DNI ya registrado',
            'dniUsuarioEditar.digits' => 'DNI debe tener exactamente 8 números',
            'telefonoUsuarioEditar.required' => 'Teléfono no ingresado',
            'telefonoUsuarioEditar.unique' => 'Teléfono ya registrado',
            'telefonoUsuarioEditar.digits' => 'Teléfono debe tener exactamente 10 números',
            'emailUsuarioEditar.required' => 'Email no ingresado',
            'emailUsuarioEditar.email' => 'Email no válido',
            'emailUsuarioEditar.unique' => 'El email ya está registrado',
            'rolUsuarioEditar.required' => 'Rol no seleccionado',
            'rolUsuarioEditar.exists' => 'El rol seleccionado no existe',
        ]);

        if ($validacion_usuario->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validacion_usuario->errors(),
            ], 422);
        }



        try {

            $usuario = Usuario::findOrFail($id);

            $usuario->Nombre = $nombre;
            $usuario->Apellido = $apellido;
            $usuario->Email = $email;
            $usuario->DNI = $dni;
            $usuario->Telefono = $telefono;
            $usuario->save();

            $usuario->roles()->sync($rol);

            return response()->json([
                'success' => true,
                'message' => "Usuario editado correctamente",
                'usuario' => $usuario->load('roles'),
            ], 200);




        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }


    public function eliminarUsuario($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->roles()->detach(); //eliminar la fila en usuario_rol
            $usuario->delete();

            return redirect()->back()->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar usuario: ' . $e->getMessage());
        }
    }


    public function obtenerUsuario($id)
    {
        $usuario = Usuario::with('roles')->find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }



    public function cambiarEstado($id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->ID_Estado_Usuario = $usuario->ID_Estado_Usuario == 1 ? 2 : 1;
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => "Estado cambiado con exito",
            'estado' => $usuario->ID_Estado_Usuario
        ]);
    }

    public function perfil($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.perfil', compact('usuario'));
    }



}
