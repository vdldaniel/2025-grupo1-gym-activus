@php
    use App\Helpers\PermisoHelper;
    $idUsuario = Auth::user()->ID_Usuario ?? null;
@endphp

@extends('layouts.app')
@section('content')

<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <div class="d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap flex-shrink-0"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>            <div>
                <h2 class="fw-bold mb-0">Biblioteca de Ejercicios</h2>
                <span class="text-secondary small">Gestiona y organiza todos los ejercicios</span>
            </div>
        </div>
    @if(PermisoHelper::tienePermiso('Gestionar Ejercicios', $idUsuario))     
        <div class="d-flex justify-content-end mt-3 mt-md-0">
            <button class="btn btn-agregar py-2 px-4" data-bs-toggle="modal" data-bs-target="#modalEjercicio">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            <span class="ms-2 small h6">Nuevo Ejercicio</span>
            </button>
        </div>
    @endif
    </div>
    

    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Total Ejercicios</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap "><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>                    </div>
                    <p id="totalEjercicios" class="display-6 fw-bold mt-4">{{ $totalEjercicios }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Grupos Musculares</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-biceps-flexed-icon lucide-biceps-flexed "><path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/><path d="M15 14a5 5 0 0 0-7.584 2"/><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/></svg>                    </div>
                    <p id="totalMusculos" class="display-6 fw-bold mt-4">{{ $totalMusculos }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Equipos</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                    </div>
                    <p id="totalEquipos" class="display-6 fw-bold mt-4">{{ $totalEquipos }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 my-4">
        <button id="btnListaEjercicios" class="btn btn-ejercicio btn-agregar">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap flex-shrink-0"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
            Lista de Ejercicios
        </button>
        @if(PermisoHelper::tienePermiso('Gestionar Ejercicios', $idUsuario))
        <button id="btnTablaEjercicios" class="btn btn-ejercicio btn-secundario">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog-icon lucide-user-cog"><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m14.305 16.53.923-.382"/><path d="m15.228 13.852-.923-.383"/><path d="m16.852 12.228-.383-.923"/><path d="m16.852 17.772-.383.924"/><path d="m19.148 12.228.383-.923"/><path d="m19.53 18.696-.382-.924"/><path d="m20.772 13.852.924-.383"/><path d="m20.772 16.148.924.383"/><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/></svg>
            Gestión de Ejercicios
        </button>
        @endif
    </div>


    <div class="card shadow-sm border-secondary rounded-2 mt-4 ">
        <div class="card-body">
            <div class="row">
                <h7 class="card-title mb-0">Buscar Ejercicios</h7>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-sm-7 col-12">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text card-input icon-input text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                        </span>
                        <input type="text" id="buscadorEjercicios" class="form-control card-input input-left text-light border-secondary" placeholder="Buscar ejercicios por nombre, tipo o id...">
                    </div>
                </div>
                <div class="col-sm col-12 row g-2 m-0 p-0">
                    <div class="col-6">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text card-input icon-input text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-biceps-flexed-icon lucide-biceps-flexed"><path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/><path d="M15 14a5 5 0 0 0-7.584 2"/><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/></svg>                     
                            </span>
                            <select id="musculoFiltro" class="form-select card-input input-left small">
                                <option value="aMusculos" selected>Todos los grupos musculares</option>
                                @foreach($musculos as $m)
                                <option value="{{ $m->Nombre_Musculo }}">{{ $m->Nombre_Musculo }}</option>
                                @endforeach
                            </select>   
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text card-input icon-input text-secondary small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                            </span>                
                            <select id="equipoFiltro" class="form-select card-input input-left">
                                <option value="aEquipos" selected>Todas los equipos</option>
                                @foreach($equipos as $e)
                                <option value="{{ $e->Nombre_Equipo }}">{{ $e->Nombre_Equipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end m-0">
                    <button type="button" class="btn text-secondary small mt-2 p-0 border-0 d-none" id="btnLimpiarFiltro">
                        <small>Limpiar filtros</small>
                    </button>
                    </div>
                </div>
            </div> 
        </div>

    </div>

    <div id="contenedor-ejercicios" class="m-0 p-0">

    </div>
</div>




    <div class="modal fade" id="modalEjercicio" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header border-0">
            <h5 class="modal-title" id="modalTitulo">Nuevo Ejercicio</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body mt-3">
            <form id="formEjercicio" action="{{ route('ejercicio.crear') }}" method="POST">
                @csrf
                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre del Ejercicio</label>
                            <input type="text" id="nombreEjercicio" class="form-control card-input" placeholder="Nombre del ejercicio" name="nombreEjercicio">
                            <div class="invalid-feedback" id="error-nombreEjercicio"></div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcionEjercicio" id="descripcionEjercicio"></textarea>
                            <div class="invalid-feedback" id="error-descripcionEjercicio"></div>        
                        </div>
                        <div class="mb-3 col-12 col-md-12">
                            <label class="form-label">Músculos</label>
                            <select id="musculos" name="musculos[]" class="form-control js-musculos" multiple="multiple">
                                @foreach($musculos as $musculo)
                                <option value="{{ $musculo->ID_Musculo }}">{{ $musculo->Nombre_Musculo }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-musculos"></div>
                        </div>
                        <div class="row g-0">
                            
                            <div class="mb-3 col-12 col-md-12">
                                <label class="form-label">Equipos necesarios</label> 
                                <select id="equipos" name="equipos[]" class="form-control js-equipos card-input" multiple="multiple">
                                    @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->ID_Equipo }}">{{ $equipo->Nombre_Equipo }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error-equipos"></div>
                            </div>
                        </div>                     
                        <div class="mb-3 col-12">
                            <label class="form-label">Instrucciones (una por linea)</label>
                            <textarea class="form-control card-input" placeholder="1. Primer paso.." name="instrucciones" id="instrucciones"></textarea>
                            <div class="invalid-feedback" id="error-instrucciones"></div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Consejos y Tips</label>
                            <textarea class="form-control card-input" placeholder="Consejos importantes para la correcta ejecución" name="tips" id="tips"></textarea>
                            <div class="invalid-feedback" id="error-tips"></div>
                        </div>
                
                    <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-agregar">Guardar</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarEjercicio" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
        <div class="modal-header border-0">
            <h5 class="modal-title" id="modalTitulo">Editar Ejercicio</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body mt-3">
        <form id="formEditarEjercicio" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="idEjercicio" name="idEjercicio">

            <div class="mb-3 col-12">
                <label class="form-label">Nombre del Ejercicio</label>
                <input type="text" id="nombreEjercicioEditar" class="form-control card-input" name="nombreEjercicio" placeholder="Nombre del ejercicio" required>
                <div class="invalid-feedback" id="error-nombreEjercicioEditar"></div>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripción</label>
                <textarea class="form-control card-input" name="descripcionEjercicio" id="descripcionEjercicioEditar" placeholder="Escribe una descripción acá..." required></textarea>
                <div class="invalid-feedback" id="error-descripcionEjercicioEditar"></div>
            </div>

                <div class="mb-3 col-12 col-md-12">
                    <label class="form-label">Músculos</label>
                    <select id="musculosEditar" name="musculos[]" class="form-control js-musculos" multiple="multiple">
                        @foreach($musculos as $musculo)
                        <option value="{{ $musculo->ID_Musculo }}">{{ $musculo->Nombre_Musculo }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="error-musculosEditar"></div>
                </div>

                <div class="row g-0">
                    <div class="mb-3 col-12 col-md-12">
                        <label class="form-label">Equipos necesarios</label> 
                        <select id="equiposEditar" name="equipos[]" class="form-control js-equipos card-input" multiple="multiple">
                            @foreach($equipos as $equipo)
                            <option value="{{ $equipo->ID_Equipo }}">{{ $equipo->Nombre_Equipo }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="error-equiposEditar"></div>
                    </div>
                </div>      


            <div class="mb-3 col-12">
                <label class="form-label">Instrucciones (una por linea)</label>
                <textarea class="form-control card-input" name="instrucciones" id="instruccionesEditar" placeholder="1. Primer paso..." required></textarea>
                <div class="invalid-feedback" id="error-instruccionesEditar"></div>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Consejos y Tips</label>
                <textarea class="form-control card-input" name="tips" id="tipsEditar" placeholder="Consejos importantes"></textarea>
                <div class="invalid-feedback" id="error-tipsEditar"></div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-agregar">Guardar</button>
            </div>

            </form>
        </div>
        </div>
    </div>
    </div>


<div class="modal fade" id="modalEliminarEjercicio" tabindex="-1" aria-labelledby="modalEliminarEjercicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header border-0">
            <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar eliminación de ejercicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro de que desea eliminar este ejercicio?</p>
        </div>
        <div class="modal-footer border-0">
            <form id="formEliminarEjercicio" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </form>
        </div>
        </div>
    </div>
</div>


@include('componentes.modal_exito')

@endsection
