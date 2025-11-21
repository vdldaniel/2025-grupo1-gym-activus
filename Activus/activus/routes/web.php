<?php

use App\Http\Controllers\EstadoUsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\EjercicioController;
use App\http\Controllers\ProfesoresController;
use App\Http\Controllers\TipoMembresiaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\GestionTipoMembresiaController;
use App\Http\Controllers\EstadoMembresiaSocioController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\NivelDificultadController;
use App\Helpers\PermisoHelper;

use App\Models\TipoMembresia;
use App\Http\Controllers\PagoSocioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioSocioController;
use App\Http\Controllers\InicioAdministrativoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\InicioProfesorController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\InicioAdministradorController;
use App\Http\Controllers\ClaseProgramadaController;
use App\Http\Controllers\ClaseSocioController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\IngresoFisicoController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/rutinas', function () {
    return view('rutinas.index');
});

Route::get('/socios', function () {
    return view('socios.index');
});

Route::get('/clases', function () {
    return view('clases.socio.index');
})->name('clases.index');


Route::get('/clases/gestion', function () {
    return view('clases.gestion');
})->name('clases.gestion');


Route::get('/clases/mis-clases', function () {
    return view('clases.mis-clases');
})->name('clases.mis-clases');

Route::get('/usuarios/perfil', function () {
    return view('usuarios.perfil');
});

Route::get('/membresias', function () {
    return view('membresias.index');
});
/*Route::get('/membresias/gestion', function () {
    return view('membresias.gestion');
});*/
Route::get('/donde-entrenar', function () {
    return view('donde-entrenar.index');
});

Route::get('/pagos', function () {
    return view('pagos.index');
});

/*Route::get('/salas', function () {
    return view('salas.index');
});*/

/*Route::get('/configuraciones', function () {
    return view('configuraciones.index');
});*/

Route::get('/asistencias', function () {
    return view('asistencias.index');
});

Route::get('/profesores', function () {
    return view('profesores.index');
});
/*Route::get('/profesores/gestion', function () {
    return view('profesores.gestion');
});*/

Route::get('/membresias/gestion', function () {
    return view('membresias.gestion');
})->name('membresias.gestion');

Route::get('/profesores/gestion', function () {
    return view('profesores.gestion');
})->name('profesores.gestion');

// === Rutas de apoyo para vista del Administrativo ===
// (no modifican funcionalidad, solo evitan errores al renderizar)

/*if (!Route::has('clases.index')) {
    Route::get('/clases', function () {
        return view('clases.index');
    })->name('clases.index');
}

if (!Route::has('profesores.index')) {
    Route::get('/profesores', function () {
        return view('profesores.index');
    })->name('profesores.index');
}*/
// =====================================================================
//  Rutas temporales de apoyo para el módulo "Inicio Administrativo"
// Estas rutas solo existen para evitar errores de vista durante pruebas.
// NO modificar vistas ajenas ni eliminar hasta que estén integradas
// las rutas reales de Clases y Profesores.
// =====================================================================


Route::get('/ingreso-gimnasio', function () {
    return view('ingreso.index');
})->name('ingreso.gimnasio');

Route::post('/ingreso/verificar', [IngresoFisicoController::class, 'verificarIngreso']);




Route::get('/estadosUsuario', [EstadoUsuarioController::class, 'index']);
Route::get('/roles', [RolController::class, 'index']);
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerUsuario'])->name('usuarios.perfil');
Route::get('/usuarios/{id}/perfil', [UsuarioController::class, 'perfil'])->name('usuarios.perfil');
Route::get('/asistencia', [AsistenciaController::class, 'obtenerAsistenciasHoy']);
Route::get('/profesores/socio', [ProfesoresController::class, 'obtenerProfesoresSocio']);
Route::get('/profesores/admin', [ProfesoresController::class, 'obtenerProfesoresAdmin']);
Route::get('/profesoresMetricas', [ProfesoresController::class, 'obtenerMetricas']);
Route::get('/profesor/{id}/clasesBase', [ProfesoresController::class, 'obtenerClasesBaseProfesor']);
Route::get('/membresias/socio', [TipoMembresiaController::class, 'obtenerMembresias']);
Route::get('/estadosMembresiaSocio', [EstadoMembresiaSocioController::class, 'index']);
Route::get('/socios', [SocioController::class, 'index']);
Route::get('/ejercicios', [EjercicioController::class, 'index']);
Route::get('/rutinas', [RutinaController::class, 'index']);
Route::get('/nivelesDificultad', [NivelDificultadController::class, 'index']);

Route::get('/socios', [SocioController::class, 'index'])->name('socios.index');
//Route::get('/membresias', [TipoMembresiaController::class, 'index'])->name('membresias.index');
Route::get('/configuraciones', [ConfiguracionController::class, 'index'])
    ->name('configuracion.index');
Route::get('/donde-entrenar', [ConfiguracionController::class, 'mostrar'])
    ->name('donde-entrenar.index');

Route::post('/usuarios/crear', [UsuarioController::class, 'crearUsuario'])->name('usuarios.crear');
Route::put('/usuarios/{id}', [UsuarioController::class, 'editarUsuario'])->name('usuarios.editar');
Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editarPerfil'])->name('usuarios.editarPerfil');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
Route::put('/usuarios/{id}/enviar', [UsuarioController::class, 'update'])->name('usuarios.enviarEdicion');
Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerUsuario']);
Route::post('/usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.cambiarEstado');
Route::post('/usuario/{id}/cambiar-correo', [UsuarioController::class, 'cambiarCorreo'])->name('usuarios.cambiarCorreo');
Route::post('/usuario/{id}/cambiar-contrasenia', [UsuarioController::class, 'cambiarContrasenia'])->name('usuarios.cambiarContrasenia');
Route::post('/usuarios/{id}/subir-certificado', [UsuarioController::class, 'subirCertificado'])->name('usuarios.subirCertificado');
Route::delete('/usuarios/{id}/eliminar-certificado/{certificado}', [UsuarioController::class, 'eliminarCertificado'])->name('usuarios.eliminarCertificado');
Route::post('/usuario/{id}/cambiar-foto', [UsuarioController::class, 'cambiarFoto'])->name('usuarios.cambiarFoto');
Route::delete('/usuarios/{id}/eliminar-foto', [UsuarioController::class, 'eliminarFoto'])->name('usuarios.eliminarFoto');

Route::post('/socios/crear', [SocioController::class, 'crearSocio'])->name('socios.crear');
Route::get('/socios/{id}/perfil', [SocioController::class, 'mostrar'])->name('socios.perfil');
Route::put('/socios/{id}', [SocioController::class, 'editarSocio'])->name('socios.editar');
Route::delete('/socios/{id}', [SocioController::class, 'eliminarSocio'])->name('socios.eliminar');


Route::get('/asistencias/filtrar', [SocioController::class, 'filtrarAsistencias']);


Route::get('/ejercicios/gestion', [EjercicioController::class, 'gestion'])->name('ejercicios.gestion');
Route::get('/ejercicios/lista', [EjercicioController::class, 'lista'])->name('ejercicios.lista');
Route::post('/ejercicios/crear', [EjercicioController::class, 'crearEjercicio'])->name('ejercicio.crear');
Route::put('/ejercicios/{id}', [EjercicioController::class, 'editarEjercicio'])->name('ejercicio.editar');
Route::delete('/ejercicios/{id}', [EjercicioController::class, 'eliminarEjercicio'])->name('ejercicio.eliminar');




Route::post('/rutinas/crear', [RutinaController::class, 'crearRutina'])->name('rutinas.crear');
Route::put('/rutinas/{id}', [RutinaController::class, 'editarRutina'])->name('rutinas.editar');
Route::delete('/rutinas/{id}', [RutinaController::class, 'eliminarRutina'])->name('rutinas.eliminar');
Route::get('/rutinas/lista', [RutinaController::class, 'lista'])->name('rutinas.lista');
Route::get('/rutinas/{id}', [RutinaController::class, 'verRutina'])->name('rutinas.ver');

Route::middleware(['auth'])->group(function () {

    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');

    Route::get('/pagos/listar', [PagoController::class, 'listar'])->name('pagos.listar');

    Route::get('/pagos/listar_membresias', [PagoController::class, 'listar_membresias'])
        ->name('pagos.listar_membresias');

    Route::get('/pagos/buscar_socio', [PagoController::class, 'buscar_socio'])
        ->name('pagos.buscar_socio');

    Route::post('/pagos/agregar', [PagoController::class, 'agregar'])
        ->name('pagos.agregar');
});


Route::get('/admin/membresias', [GestionTipoMembresiaController::class, 'index'])->name('admin.membresias');
Route::get('/admin/membresias/listar', [GestionTipoMembresiaController::class, 'listar']);
Route::post('/admin/membresias', [GestionTipoMembresiaController::class, 'store']);
Route::get('/admin/membresias/{id}', [GestionTipoMembresiaController::class, 'show']);
Route::put('/admin/membresias/{id}', [GestionTipoMembresiaController::class, 'update']);
Route::delete('/admin/membresias/{id}', [GestionTipoMembresiaController::class, 'destroy']);


Route::get('/pagos/socio', [PagoSocioController::class, 'index'])->name('pagos.socio');
Route::get('/pagos/socio/listar', [PagoSocioController::class, 'listar']);




Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        // Llamo al controlador manualmente
        $controller = app(\App\Http\Controllers\InicioAdministrativoController::class);
        $data = $controller->index()->getData();


        return view('inicio', $data);
    })->name('login');// tu vista de inicio

    Route::post('/login', [AuthController::class, 'iniciarSesion'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

});

Route::get('/inicio-socio', [InicioSocioController::class, 'index']);
Route::get('/inicio-socio/obtener-datos', [InicioSocioController::class, 'obtenerDatos']);

Route::get('/inicio/administrativo', [InicioAdministrativoController::class, 'index'])
    ->name('inicio.administrativo');

Route::get('/inicio/administrativo/resumen', [InicioAdministrativoController::class, 'resumen'])
    ->name('inicio.administrativo.resumen');


Route::post('/configuraciones', [ConfiguracionController::class, 'storeOrUpdate'])
    ->name('configuracion.storeOrUpdate');

Route::get('/inicio-profesor', [InicioProfesorController::class, 'index'])->name('inicio.profesor');
Route::get('/inicio-profesor/datos', [InicioProfesorController::class, 'datos']);


Route::get('/salas', [SalaController::class, 'index'])->name('salas.index');
Route::get('/salas/listar', [SalaController::class, 'listar'])->name('salas.listar');
Route::post('/salas', [SalaController::class, 'store'])->name('salas.store');
Route::put('/salas/{id}', [SalaController::class, 'update'])->name('salas.update');
Route::delete('/salas/{id}', [SalaController::class, 'destroy'])->name('salas.destroy');

Route::get('/inicio-administrador', [InicioAdministradorController::class, 'index'])->name('inicio.administrador');
Route::get('/inicio-administrador/datos', [InicioAdministradorController::class, 'datos']);

/// cargar el calendario con las clases programadas 
Route::get('/obtener/eventos', [ClaseProgramadaController::class, 'obtenerEventos']);

Route::get('/clases', [ClaseSocioController::class, 'index']);
Route::get('/clases-socio/eventos', [ClaseSocioController::class, 'eventos']);
Route::get('/clases-socio/disponibles', [ClaseSocioController::class, 'disponibles']);
Route::post('/clases-socio/inscribirse/{id}', [ClaseSocioController::class, 'inscribirse']);
Route::post('/clases-socio/cancelar/{id}', [ClaseSocioController::class, 'cancelar']);
Route::get('/clases-socio/metricas', [ClaseSocioController::class, 'metricas']);

Route::get('/clases/listar', [ClaseController::class, 'listar']);
Route::post('/clases/guardar', [ClaseController::class, 'guardar']);
Route::get('/clases/obtener/{id}', [ClaseController::class, 'obtener']);
Route::put('/clases/actualizar/{id}', [ClaseController::class, 'actualizar']);
Route::delete('/clases/eliminar/{id}', [ClaseController::class, 'eliminar']);
Route::get('/profesores/activos', [ProfesoresController::class, 'obtenerProfesoresActivos']);

Route::get('/clases-programadas/listar', [ClaseProgramadaController::class, 'listar']);
Route::delete('/clases-programadas/eliminar/{id}', [ClaseProgramadaController::class, 'eliminar']);
Route::get('/clases-programadas/obtener/{id}', [ClaseProgramadaController::class, 'obtener']);
Route::post('/clases-programadas/guardar', [ClaseProgramadaController::class, 'guardar']);
Route::put('/clases-programadas/actualizar/{id}', [ClaseProgramadaController::class, 'actualizar']);
Route::get('/clases/metricas', [ClaseController::class, 'obtenerMetricas']);
Route::get('/clases-programadas/{id}/alumnos', [ClaseProgramadaController::class, 'obtenerAlumnos']);