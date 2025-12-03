@php
    use App\Helpers\PermisoHelper;
    $idUsuario = Auth::user()->ID_Usuario ?? null;
@endphp

@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <div class="d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dumbbell-icon lucide-dumbbell flex-shrink-0"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
            <div>
                <h2 class="fw-bold mb-0">Catálogo de Rutinas</h2>
                <span class="text-secondary small">Rutinas de entrenamiento autoguiadas</span>
            </div>
        </div>

        @if(PermisoHelper::tienePermiso('Gestionar Rutinas', $idUsuario))
        <div class="d-flex justify-content-end mt-3 mt-md-0">
            <button class="btn btn-agregar py-2 px-4" data-bs-toggle="modal" data-bs-target="#modalRutina">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                <span class="ms-2 small h6">Nueva Rutina</span>
            </button>
        </div>
        @endif
    </div>

    <div class="row g-4">
        <div class="col-12 ">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Total Rutinas</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dumbbell-icon lucide-dumbbell "><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                    </div>
                    <p id="totalSocios" class="display-6 fw-bold mt-4">{{ $totalRutinas }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-secondary rounded-2 mt-4">
        <div class="card-body">
            <div class="row">
                <h7 class="card-title mb-0">Buscar Rutinas</h7>
                <span class="text-secondary small">Buscar y filtrar las rutinas del cátalogo</span>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-sm-9 col-12">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text card-input icon-input text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                        </span>
                        <input type="text" id="buscadorRutinas" class="form-control card-input input-left text-light border-secondary" placeholder="Buscar rutinas por nombre">
                    </div>
                </div>
                <div class="col-sm col-12 row g-2 m-0 p-0">
                
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text card-input icon-input text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel"><path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/></svg>                        </span>
                            <select id="nivelFiltro" class="form-select card-input input-left small">
                                <option value="aNiveles" selected>Todos los niveles</option>
                                @foreach($nivelesDificultad as $nd)
                                <option value="{{ $nd->Nombre_Nivel_Dificultad }}">{{ $nd->Nombre_Nivel_Dificultad }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                </div>
            </div> 
        </div>
    </div>

    <div id="contenedor-rutinas">
    
    </div>




    <div class="modal fade" id="modalRutina" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header border-0">
            <h5 class="modal-title" id="modalTitulo">Nueva Rutina</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body mt-3">
            <form id="formRutina" action="{{ route('rutinas.crear') }}" method="POST">
                @csrf
                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre de la rutina</label>
                            <input type="text" id="nombreRutina" name="nombreRutina" class="form-control card-input" placeholder="Primer nombre del socio...">
                            <div class="invalid-feedback" id="error-nombreRutina"></div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcionRutina" id="descripcionRutina"></textarea>
                            <div class="invalid-feedback" id="error-descripcionRutina"></div>
                        </div>
                        <div class="row g-2">
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Dificultad</label>
                            <select class="form-select card-input" name="dificultadRutina" id="dificultadRutina">
                            <option selected disabled value="0">Selecciona una dificultad</option>
                            @foreach($nivelesDificultad as $nd)
                                <option value="{{ $nd->ID_Nivel_Dificultad }}">{{ $nd->Nombre_Nivel_Dificultad }}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-dificultadRutina"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label class="form-label">Duración</label>
                            <input type="number" id="duracionRutina" name="duracionRutina" class="form-control card-input" placeholder="45" required>
                            <div class="invalid-feedback" id="error-duracionRutina"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label class="form-label">Días por semana</label>
                            <input type="number" id="diasRutina" name="diasRutina" class="form-control card-input" placeholder="1" required>
                            <div class="invalid-feedback" id="error-diasRutina"></div>
                        </div>
                </div>

                <hr>
                    <div id="ejercicio-container">
                        <div class="row g-2">
                        <div class=" col-12 col-md-12">
                        <label class="form-label">Ejercicio</label>
                            <select class="form-select card-input" name="ejercicioRutina[]" id="ejercicioRutina">
                            <option selected>Selecciona un Ejercicio</option>
                            @foreach($ejercicios as $ejercicio)
                                <option value="{{ $ejercicio->ID_Ejercicio }}">{{ $ejercicio->Nombre_Ejercicio }}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-ejercicioRutina"></div>
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label class="form-label">Series</label>
                            <input type="number" id="seriesRutina" name="seriesRutina[]" class="form-control card-input" placeholder="4" required>
                            <div class="invalid-feedback" id="error-seriesRutina"></div>
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label class="form-label">Repeticiones</label>
                            <input type="number" id="repeticionesRutina" name="repeticionesRutina[]" class="form-control card-input" placeholder="30" required>
                            <div class="invalid-feedback" id="error-repeticionesRutina"></div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2 mb-4">
                    <button type="button" class="btn btn-agregar py-2 px-4" id="btnAgregarEjercicioCrear">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        <span class="ms-2 small h6">Agregar Ejercicio</span>
                    </button>
                </div>

                    <div class="modal-footer border-0 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-agregar">Guardar</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarRutina" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header border-0">
            <h5 class="modal-title" id="modalTitulo">Editar Rutina</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="formEditarRutina" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="idRutina" name="idRutina">
                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre de la rutina</label>
                            <input type="text" id="nombreRutinaEditar" name="nombreRutinaEditar" class="form-control card-input" placeholder="Primer nombre del socio...">
                            <div class="invalid-feedback" id="error-nombreRutinaEditar"></div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcionRutinaEditar" id="descripcionRutinaEditar"></textarea>
                            <div class="invalid-feedback" id="error-descripcionRutinaEditar"></div>
                        </div>
                        <div class="row g-2">
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Dificultad</label>
                            <select class="form-select card-input" name="dificultadRutinaEditar" id="dificultadRutinaEditar">
                            <option selected disabled value="0">Selecciona una dificultad</option>
                            @foreach($nivelesDificultad as $nd)
                                <option value="{{ $nd->ID_Nivel_Dificultad }}">{{ $nd->Nombre_Nivel_Dificultad }}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-dificultadRutinaEditar"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label class="form-label">Duración</label>
                            <input type="number" id="duracionRutinaEditar" name="duracionRutinaEditar" class="form-control card-input" placeholder="45" required>
                            <div class="invalid-feedback" id="error-duracionRutinaEditar"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label class="form-label">Días por semana</label>
                            <input type="number" id="diasRutinaEditar" name="diasRutinaEditar" class="form-control card-input" placeholder="1" required>
                            <div class="invalid-feedback" id="error-diasRutinaEditar"></div>
                        </div>
                </div>

                <hr>
                    <div id="ejercicio-container-editar">
                        <div class="row g-2">
                        <div class=" col-12 col-md-12">
                        <label class="form-label">Ejercicio</label>
                            <select class="form-select card-input" name="ejercicioRutinaEditar[]" id="ejercicioRutinaEditar">
                            <option selected>Selecciona un Ejercicio</option>
                            @foreach($ejercicios as $ejercicio)
                                <option value="{{ $ejercicio->ID_Ejercicio }}">{{ $ejercicio->Nombre_Ejercicio }}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-ejercicioRutinaEditar"></div>
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label class="form-label">Series</label>
                            <input type="number" id="seriesRutinaEditar" name="seriesRutinaEditar[]" class="form-control card-input" placeholder="4" required>
                            <div class="invalid-feedback" id="error-seriesRutinaEditar"></div>
                        </div>
                        <div class="mb-3 col-6 col-md-6">
                            <label class="form-label">Repeticiones</label>
                            <input type="number" id="repeticionesRutinaEditar" name="repeticionesRutinaEditar[]" class="form-control card-input" placeholder="30" required>
                            <div class="invalid-feedback" id="error-repeticionesRutinaEditar"></div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2 mb-4">
                    <button type="button" class="btn btn-agregar py-2 px-4" id="btnAgregarEjercicioEditar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        <span class="ms-2 small h6">Agregar Ejercicio</span>
                    </button>
                </div>

                    <div class="d-flex justify-content-end modal-footer border-0">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-agregar">Guardar</button>
                    </div>
                </div>  
            </form>
            </div>
        </div>
        </div>
    </div>

<div class="modal fade" id="modalEliminarRutina" tabindex="-1" aria-labelledby="modalEliminarRutinaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header border-0">
            <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar eliminación de rutina</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro de que desea eliminar esta rutina?</p>
        </div>
        <div class="modal-footer border-0">
            <form id="formEliminarRutina" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </form>
        </div>
        </div>
    </div>
</div>

@vite(['resources/js/rutina.js'])


@include('componentes.modal_exito')

@endsection
