<?php

namespace App\Http\Controllers;

use App\Models\EstadoUsuario;
use App\Models\Usuario;
use App\Models\MembresiaSocio;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Certificado;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        // Cargar el usuario con sus relaciones
        $usuario = Usuario::with(['roles'])->findOrFail($id);
        $usuario = Usuario::findOrFail($id);
        $membresia = MembresiaSocio::with('tipoMembresia', 'estadoMembresiaSocio') 
            ->where('ID_Usuario_Socio', $id)
            ->latest('Fecha_Fin')
            ->select(
                'membresia_socio.*',
                DB::raw('DATEDIFF(Fecha_Fin, CURDATE()) AS diasRestantes')
            )
            ->first();

        $diasRestantes = null;
        $vencimiento = null;

        if ($membresia) {

            $diasRestantes = $membresia->diasRestantes;


            $vencimiento = Carbon::parse($membresia->Fecha_Fin)->format('d/m/Y');
        }




        $socio = \App\Models\Socio::where('ID_Usuario', $usuario->ID_Usuario)
            ->with('usuario')
            ->first();

        $rolId = $usuario->roles->first()->ID_Rol ?? null;


        $certificados = \App\Models\Certificado::where('ID_Usuario_Socio', $usuario->ID_Usuario)->get();

        $anioActual = Carbon::now()->year;


        $certificados = $usuario->certificados;

        // Verificar si existe el certificado del año actual
        $certificadoEsteAnio = $certificados->firstWhere(function ($c) use ($anioActual) {
            return Carbon::parse($c->Fecha_Emision)->year == $anioActual;
        });
        // Verificar si tiene al menos un certificado aprobado
        $tieneCertificado = $certificados->where('Aprobado', 1)->isNotEmpty();

        return view('usuarios.perfil', compact('usuario', 'membresia', 'diasRestantes', 'vencimiento', 'socio', 'rolId', 'certificados', 'tieneCertificado', 'certificadoEsteAnio', 'anioActual'));
    }

    public function editarPerfil($id)
    {

        $usuario = Usuario::with(['roles', 'certificados'])->findOrFail($id);


        $membresia = MembresiaSocio::with('tipoMembresia')
            ->where('ID_Usuario_Socio', $id)
            ->latest('Fecha_Fin')
            ->first();


        $rolId = $usuario->roles->first()->ID_Rol ?? null;

        // Si el usuario es un socio (rol 4), traer sus datos de socio
        $socio = null;
        if ($rolId === 4) {
            $socio = \App\Models\Socio::where('ID_Usuario', $usuario->ID_Usuario)
                ->with('usuario')
                ->first();
        }

        // Usar los certificados ya cargados por la relación
        $certificados = $usuario->certificados;

        // Obtener el año actual
        $anioActual = now()->year;


        $certificadoEsteAnio = $certificados->first(function ($c) use ($anioActual) {
            return \Carbon\Carbon::parse($c->Fecha_Emision)->year == $anioActual;
        });

        // Verificar si tiene al menos un certificado aprobado
        $tieneCertificado = $certificados->contains('Aprobado', 1);

        // Retornar la vista con todas las variables
        return view('usuarios.editar_perfil', compact(
            'usuario',
            'membresia',
            'rolId',
            'socio',
            'certificados',
            'tieneCertificado',
            'certificadoEsteAnio',
            'anioActual'
        ));
    }


    public function update(Request $request, $id)
    {
        // Buscar usuario (findOrFail usa la primaryKey declarada en el modelo)
        $usuario = Usuario::with('roles', 'socio')->findOrFail($id);

        // Validación
        $validated = $request->validate([
            'Nombre' => ['required', 'string', 'max:100'],
            'Apellido' => ['required', 'string', 'max:100'],
            'Telefono' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9\-\s]+$/'],
            'Fecha_Nacimiento' => ['nullable', 'date', 'before:today'],
        ]);

        DB::beginTransaction();

        try {
            // Actualizar usuario
            $usuario->Nombre = $validated['Nombre'];
            $usuario->Apellido = $validated['Apellido'];
            $usuario->Telefono = $validated['Telefono'] ?? null;
            $usuario->save();

            //  rol "Socio" (ID 4)

            $esSocio = $usuario->roles->contains('ID_Rol', 4);

            if ($esSocio && array_key_exists('Fecha_Nacimiento', $validated)) {
                $socio = $usuario->socio;
                if ($socio) {
                    $socio->Fecha_Nacimiento = $validated['Fecha_Nacimiento'];
                    $socio->save();
                }
            }

            DB::commit();

            // Si la petición vino por AJAX, devolver JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado correctamente.',
                    'usuario' => $usuario->fresh(['roles', 'socio']),
                ]);
            }


            return redirect()
                ->route('usuarios.perfil', $usuario->ID_Usuario)
                ->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Manejo para petición AJAX
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar perfil: ' . $e->getMessage(),
                ], 500);
            }

            // Para peticiones normales: volver con error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar perfil: ' . $e->getMessage());
        }
    }

    public function cambiarCorreo(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return back()->withErrors(['usuario' => 'Usuario no encontrado.']);
        }

        $validator = Validator::make($request->all(), [
            'nuevoCorreo' => 'required|email|unique:usuario,Email,' . $id . ',ID_Usuario',
        ], [
            'nuevoCorreo.required' => 'Debes ingresar un correo.',
            'nuevoCorreo.email' => 'Formato de correo inválido.',
            'nuevoCorreo.unique' => 'Ese correo ya está en uso.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'modalCambiarCorreo');
        }

        $usuario->Email = $request->input('nuevoCorreo');
        $usuario->save();

        return back()
            ->with('modal', 'modalCambiarCorreo')
            ->with('success', 'Correo actualizado correctamente.');
    }



    public function cambiarContrasenia(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return back()
                ->withErrors(['usuario' => 'Usuario no encontrado.'])
                ->with('modal', 'modalCambiarContrasenia');
        }

        // Validar los campos del formulario
        $validator = Validator::make($request->all(), [
            'contraseniaActual' => ['required'],
            'nuevaContrasenia' => ['required', 'min:8'],
            'repetirContrasenia' => ['required', 'same:nuevaContrasenia'],
        ], [
            'contraseniaActual.required' => 'Debes ingresar tu contraseña actual.',
            'nuevaContrasenia.required' => 'Debes ingresar una nueva contraseña.',
            'nuevaContrasenia.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'repetirContrasenia.required' => 'Debes repetir la nueva contraseña.',
            'repetirContrasenia.same' => 'Las contraseñas no coinciden.',
        ]);

        // Si hay errores de validación
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'modalCambiarContrasenia');
        }

        if (!Hash::check($request->input('contraseniaActual'), $usuario->Contrasena)) {
            return back()
                ->withErrors(['contraseniaActual' => 'La contraseña actual no es correcta.'])
                ->with('modal', 'modalCambiarContrasenia'); // para reabrir el modal
        }


        $usuario->Contrasena = $request->input('nuevaContrasenia');
        $usuario->save();

        return back()
            ->with('modal', 'modalCambiarContrasenia')
            ->with('success', 'La contraseña se actualizó correctamente.');
    }

    public function subirCertificado(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'certificado' => 'required|mimes:jpeg,png,jpg|max:2048',
        ], [
            'certificado.required' => 'Debe seleccionar un archivo.',
            'certificado.mimes' => 'El archivo debe ser JPG o PNG.',
            'certificado.max' => 'El tamaño máximo permitido es de 2 MB.',
        ]);


        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'certificadoModal');
        }


        $anioActual = Carbon::now()->year;


        // Verificar si ya existe un certificado para este usuario y año
        $existe = Certificado::where('ID_Usuario_Socio', $id)
            ->whereYear('Fecha_Emision', $anioActual)
            ->exists();

        if ($existe) {
            return back()
                ->with('modal', 'certificadoModal')
                ->with('warning', 'Ya existe un certificado para el año ' . $anioActual . '.');
            // ->withErrors(['certificado' => 'Ya existe un certificado para el año ' . $anioActual . '.']);
        }

        // Guardar la imagen en storage/app/public/certificados
        $path = $request->file('certificado')->store('certificados', 'public');

        $certificado = new Certificado();
        $certificado->ID_Usuario_Socio = $id;
        $certificado->Imagen_Certificado = $path;
        $certificado->Aprobado = 1;
        $certificado->Fecha_Emision = Carbon::now();
        $certificado->Fecha_Vencimiento = Carbon::now()->addYear(); // opcional, un año después
        $certificado->save();

        return back()

            ->with('modal', 'certificadoModal')
            ->with('success', 'Certificado subido correctamente.');
    }

    public function eliminarCertificado($id, $certificadoId)
    {
        $certificado = Certificado::where('ID_Usuario_Socio', $id)
            ->where('ID_Certificado', $certificadoId)
            ->firstOrFail();

        // Eliminar archivo físico si existe
        if (Storage::disk('public')->exists($certificado->Imagen_Certificado)) {
            Storage::disk('public')->delete($certificado->Imagen_Certificado);
        }

        // Eliminar registro de la base de datos
        $certificado->delete();

        return back()
            ->with('modal', 'certificadoModal')
            ->with('success', 'Certificado eliminado correctamente.');
    }

    public function cambiarFoto(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return back()->with('error', 'Usuario no encontrado.')
                ->with('modal', 'modalCambiarFoto');
        }

        $validator = Validator::make($request->all(), [
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ], [
            'foto.required' => 'Debe seleccionar una imagen.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'Solo se permiten formatos JPEG, PNG, JPG, GIF o WEBP.',
            'foto.max' => 'La imagen no puede superar los 2MB.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'modalCambiarFoto');
        }

        // Guardar imagen
        $path = $request->file('foto')->store('fotos_perfil', 'public');

        // Borrar imagen anterior (si existe)
        if ($usuario->Foto_Perfil && Storage::disk('public')->exists($usuario->Foto_Perfil)) {
            Storage::disk('public')->delete($usuario->Foto_Perfil);
        }

        $usuario->Foto_Perfil = $path;
        $usuario->save();

        return back()->with('success', 'Foto actualizada correctamente.')
            ->with('modal', 'modalCambiarFoto');
    }

    public function eliminarFoto($id)
    {
        $usuario = Usuario::findOrFail($id);

        if ($usuario->Foto_Perfil) {
            // Ruta completa al archivo dentro de storage/app/public/
            $path = 'public/' . $usuario->Foto_Perfil;

            if (Storage::exists($path)) {
                Storage::delete($path);
            }


            $usuario->Foto_Perfil = null;
            $usuario->save();
        }

        return back()
            ->with('modal', 'modalCambiarFoto')
            ->with('success', 'La foto de perfil fue eliminada correctamente.');
    }
}
