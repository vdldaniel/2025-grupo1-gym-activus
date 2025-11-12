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
    return view('clases.index');
});

Route::get('/usuarios/perfil', function () {
    return view('usuarios.perfil');
});

Route::get('/membresias', function () {
    return view('membresias.index');
});
Route::get('/membresias/gestion', function () {
    return view('membresias.gestion');
});
Route::get('/donde-entrenar', function () {
    return view('donde-entrenar.index');
});

Route::get('/pagos', function () {
    return view('pagos.index');
});

Route::get('/salas', function () {
    return view('salas.index');
});

Route::get('/configuraciones', function () {
    return view('configuraciones.index');
});

Route::get('/asistencias', function () {
    return view('asistencias.index');
});

Route::get('/profesores', function () {
    return view('profesores.index');
});
Route::get('/profesores/gestion', function () {
    return view('profesores.gestion');
});


Route::get('/estadosUsuario', [EstadoUsuarioController::class, 'index']);
Route::get('/roles', [RolController::class, 'index']);
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerUsuario'])->name('usuarios.perfil');
Route::get('/usuarios/{id}/perfil', [UsuarioController::class, 'perfil'])->name('usuarios.perfil');
Route::get('/asistencia', [AsistenciaController::class, 'obtenerAsistenciasHoy']);
Route::get('/profesores/socio', [ProfesoresController::class, 'obtenerProfesoresSocio']);
Route::get('/profesores/admin', [ProfesoresController::class, 'obtenerProfesoresAdmin']);
Route::get('/profesoresMetricas', [ProfesoresController::class, 'obtenerMetricas']);
Route::get('/membresias/socio', [TipoMembresiaController::class, 'obtenerMembresias']);
Route::get('/estadosMembresiaSocio', [EstadoMembresiaSocioController::class, 'index']);
Route::get('/socios', [SocioController::class, 'index']);
Route::get('/ejercicios', [EjercicioController::class, 'index']);
Route::get('/rutinas', [RutinaController::class, 'index']);
Route::get('/nivelesDificultad', [NivelDificultadController::class, 'index']);


Route::post('/usuarios/crear', [UsuarioController::class, 'crearUsuario'])->name('usuarios.crear');
Route::put('/usuarios/{id}', [UsuarioController::class, 'editarUsuario'])->name('usuarios.editar');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerUsuario']);
Route::post('/usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.cambiarEstado');

Route::post('/socios/crear', [SocioController::class, 'crearSocio'])->name('socios.crear');
Route::put('/socios/{id}', [SocioController::class, 'editarSocio'])->name('socios.editar');
Route::delete('/socios/{id}', [SocioController::class, 'eliminarSocio'])->name('socios.eliminar');

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




Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
Route::get('/pagos/listar', [PagoController::class, 'listar'])->name('pagos.listar');
Route::get('/pagos/listar_membresias', [PagoController::class, 'listar_membresias'])->name('pagos.listar_membresias');
Route::get('/pagos/buscar_socio', [PagoController::class, 'buscar_socio'])->name('pagos.buscar_socio');
Route::post('/pagos/agregar', [PagoController::class, 'agregar'])->name('pagos.agregar');


Route::get('/admin/membresias', [GestionTipoMembresiaController::class, 'index'])->name('admin.membresias');
Route::get('/admin/membresias/listar', [GestionTipoMembresiaController::class, 'listar']);
Route::post('/admin/membresias', [GestionTipoMembresiaController::class, 'store']);
Route::get('/admin/membresias/{id}', [GestionTipoMembresiaController::class, 'show']);
Route::put('/admin/membresias/{id}', [GestionTipoMembresiaController::class, 'update']);
Route::delete('/admin/membresias/{id}', [GestionTipoMembresiaController::class, 'destroy']);

