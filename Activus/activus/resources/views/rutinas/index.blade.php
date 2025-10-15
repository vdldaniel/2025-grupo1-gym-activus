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

        <div class="d-flex justify-content-end mt-3 mt-md-0">
            <button class="btn btn-agregar py-2 px-4" data-bs-toggle="modal" data-bs-target="#modalRutina">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                <span class="ms-2 small h6">Nueva Rutina</span>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 ">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Total Rutinas</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dumbbell-icon lucide-dumbbell "><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                    </div>
                    <p id="totalSocios" class="display-6 fw-bold mt-4">0</p>
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
                            <select class="form-select card-input input-left small">
                                <option selected>Todos las rutinas</option>
                                <option value="1">Propias</option>
                                <option value="2">Otras</option>
                            </select>
                        </div>
                    
                </div>
            </div> 
        </div>
    </div>

    <div class="row g-4 mt-2 mb-4">
    <div class="col-12 col-lg-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-start mt-3">
                <div class="flex-grow-1">
                <h5 class="card-title mb-1">Nombre de la Rutina</h5>
                <span class="card-text small mb-0">Descripción breve de la rutina</span>
                </div>

                <div class="dropdown">
                <button class="btn btn-sm" type="button" id="menuRutina" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuRutina">
                    <li><a class="dropdown-item small" href="#" data-bs-target="#modalRutinaEditar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>    
                    Editar</a></li>
                    <li><a class="dropdown-item text-danger small" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Eliminar</a></li>
                </ul>
                </div>
            </div>

            <div class="card-body">

                <div class="mb-3">
                <span class="badge bg-primary me-2">Dificultad</span>
                </div>

                <div class="row  mb-3 small">
                <div class="col d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                    <span class="ms-2" id="minutos">0</span> 
                    <span class="ms-1">min</span>                   
                </div>
                <div class="col d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                    <span class="ms-2" id="cantidadSemanal">0</span> 
                    <span class="ms-1">x/semana</span>     
                </div>
                </div>

                <div>
                <p class="mb-1 fw-medium small">
                Ejercicios (<span class="" id="totalEjercicios">0</span>):
                </p>

                <div class="small">
                    <div class="text-secondary">
                        <span class="ms-1">•</span>
                        <span class="mx-2" id="nombreEjercicio">Ejercicio</span> 
                        <span class="" id="series">0</span> 
                        <span class="">x</span>
                        <span class="" id="repeticioness">0</span>      
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</div>




    <div class="modal fade" id="modalRutina" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitulo">Nueva Rutina</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="formRutina">

                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre de la rutina</label>
                            <input type="text" id="nombreRutina" class="form-control card-input" placeholder="Primer nombre del socio..." required>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcion" id="descripcionRutina"></textarea>
                        </div>
                        <div class="row g-2">
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Dificultad</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona una dificultad</option>
                            <option value="1">Principiante</option>
                            <option value="2">Medio</option>
                            <option value="3">Experto</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Duración</label>
                        <input type="num" id="duracionRutina" class="form-control card-input" placeholder="45" required>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Días por semana</label>
                        <input type="num" id="diasRutina" class="form-control card-input" placeholder="1" required>
                        </div>
                </div>

                <hr>
                <div class="row g-2">
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Ejercicio</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona un Ejercicio</option>
                            <option value="1">Nombre ejercicio</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Series</label>
                        <input type="num" id="duracionRutina" class="form-control card-input" placeholder="45" required>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Repeticiones</label>
                        <input type="num" id="semanasRutina" class="form-control card-input" placeholder="1" required>
                        </div>
                </div>

                <div class="d-flex justify-content-center mt-2 mb-4">
                    <button class="btn btn-agregar py-2 px-4" id="btnAgregarEjercicio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        <span class="ms-2 small h6">Agregar Ejercicio</span>
                    </button>
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

    <div class="modal fade" id="modalRutinaEditar" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitulo">Editar Rutina</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="formRutina">

                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre de la rutina</label>
                            <input type="text" id="nombreRutina" class="form-control card-input" placeholder="Primer nombre del socio..." required>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcion" id="descripcionRutina"></textarea>
                        </div>
                        <div class="row g-2">
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Dificultad</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona una dificultad</option>
                            <option value="1">Principiante</option>
                            <option value="2">Medio</option>
                            <option value="3">Experto</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Duración</label>
                        <input type="num" id="duracionRutina" class="form-control card-input" placeholder="45" required>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Días por semana</label>
                        <input type="num" id="diasRutina" class="form-control card-input" placeholder="1" required>
                        </div>
                </div>

                <hr>
                <div class="row g-2">
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Ejercicio</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona un Ejercicio</option>
                            <option value="1">Nombre ejercicio</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Series</label>
                        <input type="num" id="duracionRutina" class="form-control card-input" placeholder="45" required>
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                        <label class="form-label">Repeticiones</label>
                        <input type="num" id="semanasRutina" class="form-control card-input" placeholder="1" required>
                        </div>
                </div>

                <div class="d-flex justify-content-center mt-2 mb-4">
                    <button class="btn btn-agregar py-2 px-4" id="btnAgregarEjercicio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        <span class="ms-2 small h6">Agregar Ejercicio</span>
                    </button>
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
</div>
@endsection
