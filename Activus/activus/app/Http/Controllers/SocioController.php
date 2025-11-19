<?php

namespace App\Http\Controllers;

use App\Models\EstadoMembresiaSocio;
use App\Models\MembresiaSocio;
use App\Models\Usuario;
use App\Models\Socio;
use App\Models\Rol;
use App\Models\TipoMembresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Asistencia;

class SocioController extends Controller
{
    public function index(Request $request)
    {
        // Datos
        $socios = Socio::with(['membresias', 'usuario'])->get();
        $membresias = TipoMembresia::all();
        $estadosMembresiaSocio = EstadoMembresiaSocio::all();

        $totalSocios = Socio::distinct('ID_Usuario')->count();

        $totalSociosActivos = MembresiaSocio::where('ID_Estado_Membresia_Socio', 1)
            ->whereIn('ID_Usuario_Socio', function ($query) {
                $query->select('ID_Usuario')->from('socio');
            })
            ->count();

        $totalSociosNuevosMes = Socio::join('usuario', 'socio.ID_Usuario', '=', 'usuario.ID_Usuario')
            ->whereMonth('usuario.Fecha_Alta', now()->month)
            ->whereYear('usuario.Fecha_Alta', now()->year)
            ->count();

        // ORDENAMIENTO
        $sort = $request->get('sort', 'Fecha');
        $direction = $request->get('direction', 'desc');

        // QUERY INGRESOS
        $ingresosQuery = Asistencia::select(
            'asistencia.ID_Asistencia',
            'asistencia.ID_Socio',
            'asistencia.Fecha',
            'asistencia.Hora',
            'usuario.Nombre',
            'usuario.Apellido',
            'usuario.DNI'
        )
            ->join('socio', 'asistencia.ID_Socio', '=', 'socio.ID_Usuario')
            ->join('usuario', 'socio.ID_Usuario', '=', 'usuario.ID_Usuario');

        // FILTRO BUSCADOR
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $ingresosQuery->where(function ($q) use ($buscar) {
                $q->where('usuario.Nombre', 'LIKE', "%$buscar%")
                    ->orWhere('usuario.Apellido', 'LIKE', "%$buscar%")
                    ->orWhere('usuario.DNI', 'LIKE', "%$buscar%")
                    ->orWhere('asistencia.ID_Socio', 'LIKE', "%$buscar%");
            });
        }

        // FILTRO FECHA DESDE
        if ($request->filled('desde')) {
            $ingresosQuery->where('asistencia.Fecha', '>=', $request->desde);
        }

        // FILTRO FECHA HASTA
        if ($request->filled('hasta')) {
            $ingresosQuery->where('asistencia.Fecha', '<=', $request->hasta);
        }

        // ORDEN FINAL
        $ingresos = $ingresosQuery->orderBy($sort, $direction)->get();

        return view('socios.index', compact(
            'socios',
            'membresias',
            'estadosMembresiaSocio',
            'totalSocios',
            'totalSociosActivos',
            'totalSociosNuevosMes',
            'ingresos'
        ));
    }




    public function crearSocio(Request $request)
    {
        $nombre = $request->input('nombreSocio');
        $apellido = $request->input('apellidoSocio');
        $dni = $request->input('dniSocio');
        $telefono = $request->input('telefonoSocio');
        $email = $request->input('emailSocio');
        $fechaNacimiento = $request->input('fechaNacSocio');
        $membresia = $request->input('membresiaSocio');
        $estadoMembresia = 3; // Pendiente
        $path = 'images/default/profile-default.jpg';
        $rol = 4; // ID del rol Socio


        $validacion_socio = Validator::make($request->all(), [
            'nombreSocio' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'apellidoSocio' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'dniSocio' => ['required', 'digits:8', 'unique:usuario,dni', 'regex:/^[0-9]+$/'],
            'telefonoSocio' => ['required', 'digits:10', 'unique:usuario,telefono', 'regex:/^[0-9]+$/'],
            'emailSocio' => ['required', 'email', 'unique:usuario,Email'],
            'fechaNacSocio' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d')
            ],
            'membresiaSocio' => ['required', 'exists:tipo_membresia,ID_Tipo_Membresia'],
        ], [
            'nombreSocio.required' => 'Nombre no ingresado',
            'nombreSocio.max' => 'El nombre debe tener menos de 50 carácteres',
            'nombreSocio.min' => 'El nombre debe tener más de 2 carácteres',
            'nombreSocio.regex' => 'El nombre solo puede contener letras y espacios',
            'apellidoSocio.regex' => 'El apellido solo puede contener letras y espacios',
            'apellidoSocio.required' => 'Apellido no ingresado',
            'apellidoSocio.max' => 'El apellido debe tener menos de 50 carácteres',
            'apellidoSocio.min' => 'El apellido debe tener más de 2 carácteres',
            'dniSocio.regex' => 'El DNI solo puede contener números',
            'dniSocio.required' => 'DNI no ingresado',
            'dniSocio.unique' => 'DNI ya registrado',
            'dniSocio.digits' => 'DNI debe tener exactamente 8 números',
            'telefonoSocio.required' => 'Teléfono no ingresado',
            'telefonoSocio.unique' => 'Teléfono ya registrado',
            'telefonoSocio.digits' => 'Teléfono debe tener exactamente 10 números',
            'emailSocio.required' => 'Email no ingresado',
            'emailSocio.email' => 'Email no válido',
            'emailSocio.unique' => 'El email ya está registrado',
            'fechaNacSocio.required' => 'Fecha de nacimiento no ingresada',
            'fechaNacSocio.date' => 'Fecha de nacimiento no válida',
            'fechaNacSocio.before_or_equal' => 'El socio debe ser mayor de 18 años',
            'membresiaSocio.required' => 'Membresía no seleccionada',
            'membresiaSocio.exists' => 'La membresía seleccionada no existe',
        ]);

        if ($validacion_socio->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validacion_socio->errors(),
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

            Socio::create([
                'ID_Usuario' => $usuario->ID_Usuario,
                'Fecha_Nacimiento' => $fechaNacimiento,
            ]);



            MembresiaSocio::create([
                "ID_Usuario_Socio" => $usuario->ID_Usuario,
                "ID_Tipo_Membresia" => $membresia,
                "Fecha_Inicio" => null,
                "Fecha_Fin" => null,
                "ID_Estado_Membresia_Socio" => $estadoMembresia,
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

    public function editarSocio(Request $request, $id)
    {
        $nombre = $request->input('nombreSocioEditar');
        $apellido = $request->input('apellidoSocioEditar');
        $dni = $request->input('dniSocioEditar');
        $telefono = $request->input('telefonoSocioEditar');
        $email = $request->input('emailSocioEditar');
        $fechaNacimiento = $request->input('fechaNacSocio');



        $validacion_usuario = Validator::make($request->all(), [
            'nombreSocioEditar' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'apellidoSocioEditar' => ['required', 'string', 'max:50', 'min:2', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'dniSocioEditar' => ['required', 'digits:8', 'regex:/^[0-9]+$/', Rule::unique('usuario', 'DNI')->ignore($id, 'ID_Usuario'),],
            'telefonoSocioEditar' => ['required', 'digits:10', 'regex:/^[0-9]+$/', Rule::unique('usuario', 'Telefono')->ignore($id, 'ID_Usuario')],
            'emailSocioEditar' => ['required', 'email', Rule::unique('usuario', 'Email')->ignore($id, 'ID_Usuario'),],
            'fechaNacSocioEditar' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d')
            ],
        ], [
            'nombreSocioEditar.required' => 'Nombre no ingresado',
            'nombreSocioEditar.max' => 'El nombre debe tener menos de 50 carácteres',
            'nombreSocioEditar.min' => 'El nombre debe tener más de 2 carácteres',
            'nombreSocioEditar.regex' => 'El nombre solo puede contener letras y espacios',
            'apellidoSocioEditar.regex' => 'El apellido solo puede contener letras y espacios',
            'apellidoSocioEditar.required' => 'Apellido no ingresado',
            'apellidoSocioEditar.max' => 'El apellido debe tener menos de 50 carácteres',
            'apellidoSocioEditar.min' => 'El apellido debe tener más de 2 carácteres',
            'dniSocioEditar.regex' => 'El DNI solo puede contener números',
            'dniSocioEditar.required' => 'DNI no ingresado',
            'dniSocioEditar.unique' => 'DNI ya registrado',
            'dniSocioEditar.digits' => 'DNI debe tener exactamente 8 números',
            'telefonoSocioEditar.required' => 'Teléfono no ingresado',
            'telefonoSocioEditar.unique' => 'Teléfono ya registrado',
            'telefonoSocioEditar.digits' => 'Teléfono debe tener exactamente 10 números',
            'emailSocioEditar.required' => 'Email no ingresado',
            'emailSocioEditar.email' => 'Email no válido',
            'emailSocioEditar.unique' => 'El email ya está registrado',
            'fechaNacSocioEditar.required' => 'Fecha de nacimiento no ingresada',
            'fechaNacSocioEditar.date' => 'Fecha de nacimiento no válida',
            'fechaNacSocioEditar.before_or_equal' => 'El socio debe ser mayor de 18 años',
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

            $socio = Socio::findOrFail($id);

            $socio->Fecha_Nacimiento = $fechaNacimiento;
            $socio->save();

            return response()->json([
                'success' => true,
                'message' => "Usuario editado correctamente",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }


    public function eliminarSocio($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->roles()->detach(); //eliminar la fila en usuario_rol
            $usuario->delete();

            return redirect()->back()->with('success', 'Socio eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar socio: ' . $e->getMessage());
        }
    }


    // Método para ver un socio específico
    public function mostrar($id)
    {

        $usuario = Usuario::with(['roles', 'socio'])->findOrFail($id);


        $rol = $usuario->roles->first();


        $rolId = $rol ? $rol->ID_Rol : null;


        $socio = $usuario->socio;


        return view('usuarios.perfil', compact('usuario', 'rolId', 'socio'));
    }

    public function filtrarIngresos(Request $request)
    {
        $buscar = $request->buscar;
        $desde  = $request->desde;
        $hasta  = $request->hasta;

        $query = Asistencia::select(
            'asistencia.ID_Asistencia',
            'asistencia.ID_Socio',
            'asistencia.Fecha',
            'asistencia.Hora',
            'usuario.Nombre',
            'usuario.Apellido',
            'usuario.DNI'
        )
            ->join('socio', 'asistencia.ID_Socio', '=', 'socio.ID_Usuario')
            ->join('usuario', 'socio.ID_Usuario', '=', 'usuario.ID_Usuario')
            ->orderBy('asistencia.Fecha', 'DESC')
            ->orderBy('asistencia.Hora', 'DESC');

        // FILTRO BUSCAR
        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('usuario.Nombre', 'LIKE', "%$buscar%")
                    ->orWhere('usuario.Apellido', 'LIKE', "%$buscar%")
                    ->orWhere('usuario.DNI', 'LIKE', "%$buscar%")
                    ->orWhere('asistencia.ID_Socio', 'LIKE', "%$buscar%");
            });
        }

        // FILTRO FECHA DESDE
        if ($desde) {
            $query->whereDate('asistencia.Fecha', '>=', $desde);
        }

        // FILTRO FECHA HASTA
        if ($hasta) {
            $query->whereDate('asistencia.Fecha', '<=', $hasta);
        }

        $ingresos = $query->get();

        return response()->json([
            "success" => true,
            "data" => $ingresos
        ]);
    }
}
