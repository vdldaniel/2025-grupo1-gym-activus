<?php

use App\Http\Controllers\EstadoUsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AsistenciaController;
use App\http\Controllers\ProfesoresController;
use App\Http\Controllers\TipoMembresiaController;
use App\Http\Controllers\PagoController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/rutinas', function () {
    return view('rutinas.index');
});

Route::get('/ejercicios', function () {
    return view('ejercicios.index');
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

Route::get('/profesores', function () {
    return view('profesores.index');
});

Route::get('/membresias', function () {
    return view('membresias.index');
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


Route::post('/usuarios/crear', [UsuarioController::class, 'crearUsuario'])->name('usuarios.crear');
Route::put('/usuarios/{id}', [UsuarioController::class, 'editarUsuario'])->name('usuarios.editar');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerUsuario']);
Route::post('/usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.cambiarEstado');


Route::get('/pagos-admin', [PagoController::class, 'admin'])->name('pagos.admin');
Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
Route::get('/pagos/listar', [PagoController::class, 'listar']);
Route::get('/pagos/listar_membresias', [PagoController::class, 'listarMembresias']);
Route::get('/pagos/buscar_socio', [PagoController::class, 'buscarSocio']);
Route::post('/pagos/agregar', [PagoController::class, 'agregar']);






