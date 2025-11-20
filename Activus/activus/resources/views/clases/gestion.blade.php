@extends('layouts.app')
@section('content')
    <div class="container py-4">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-icon lucide-calendar">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                </svg>

                <div>
                    <h2 class="fw-bold mb-0">Clases</h2>
                    <span class="text-secondary small">Administra las clases y horarios </span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                <button id="btnNuevaClase" class="btn  btn-nuevaClase py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                    <span class="ms-2 small h6">Nueva Clase</span>
                </button>

                <button id="btnProgramarClase" class="btn btn-agregar py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                    </svg>
                    <span class="ms-2 small h6">Programar Clase</span>
                </button>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Total de clases</h6>
                        <div class="text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-calendar">
                                <path d="M8 2v4" />
                                <path d="M16 2v4" />
                                <rect width="18" height="18" x="3" y="4" rx="2" />
                                <path d="M3 10h18" />
                            </svg>
                        </div>
                    </div>
                    <h4 id="metricTotalClases" class="display-6 fw-bold mt-4 mb-0">-</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Clases De Hoy</h6>
                        <div class="text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-clock">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>

                    </div>
                    <h4 id="metricClasesHoy" class="display-6 fw-bold mt-4 mb-0">-</h4>
                </div>

            </div>
        </div>


        <!-- botones cambiar seccion  -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="btn btn-tab active" id="btnHorario"><i class="bi bi-calendar me-2"></i>Vista de horarios</button>
            <button class="btn btn-tab" id="btnProgramadas"><i class="bi bi-people  me-2"></i>Gestión de Clases
                Programadas</button>
            <button class="btn btn-tab" id="btnClases"><i class="bi bi-people me-2"></i>Gestión de
                Clases</button>
        </div>

        <!-- calendario /cargado con ajax -->
        <div id="seccionHorario" class="card p-3">

            <div id="calendar"></div>
        </div>

        <!-- seccion clases programadas-->
        <div id="seccionProgramadas" class="card p-3 d-none">
            <h6 class="mb-3">Lista de Clases Programadas</h6>
            <div class="table-responsive">
                <table class="table table-hover mt-3 small">
                    <thead>
                        <tr>
                            <th>Nombre de la Clase</th>
                            <th>Profesor</th>
                            <th>Capacidad</th>
                            <th>Sala</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaClasesProgramadas">

                    </tbody>
                </table>
            </div>
        </div>



        <!--seccion de clases -->
        <div id="seccionClases" class="card p-3 d-none">
            <h6 class="mb-3">Gestion de Clases </h6>
            <div class="table-responsive">
                <table class="table table-hover small border-round">
                    <thead>
                        <tr>
                            <th>Nombre de la clase</th>
                            <th>Profesor</th>
                            <th>Capacidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaClases">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modalClase" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Crear Nueva Clase</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formClase">
                        <div class="mb-3">
                            <label for="NombreClase" class="form-label">Nombre</label>
                            <input type="text" id="NombreClase" class="form-control card-input" name="NombreClase" required>
                            <div id="ErrorNombreClase" class="invalid-feedback"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="Profesor" class="form-label ">Profesor</label>
                                <select class="form-select card-input" id="Profesor" name="Profesor" required>
                                    <option value="">Seleccione..</option>

                                </select>
                                <div id="ErrorProfesorClase" class="invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="Capacidad" class="form-label">Capacidad</label>
                                <input type="number" class="form-control card-input" id="Capacidad" name="Capacidad"
                                    required>
                                <div id="ErrorCapacidadClase" class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-agregar" id="btnCrearClase">Crear Clase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalClaseProgramada" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Programar Sesión de Clase</h5>

                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formProgramarClase">
                        <div class="row mb-3">

                            <div class="col">
                                <div class="mb-3">
                                    <label for="SelectClase" class="form-label ">Seleccionar Clase</label>
                                    <select class="form-select card-input" id="SelectClase" name="SelectClase" required>
                                        <option value="">Seleccione..</option>

                                    </select>
                                    <div id="ErrorSelectClase" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="FechaClase" class="form-label">Fecha</label>
                                <input type="date" id="FechaClase" name="FechaClase" class="form-control card-input"
                                    required>
                                <div id="ErrorFechaClase" class="invalid-feedback"></div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="HoraInicio" class="form-label">Hora de Inicio</label>
                                    <input type="time" id="HoraInicio" name="HoraInicio" class="form-control card-input"
                                        required>
                                    <div id="ErrorHoraInicio" class="invalid-feedback"></div>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="HoraFin" class="form-label">Hora de Fin</label>
                                    <input type="time" id="HoraFin" name="HoraFin" class="form-control card-input" required>
                                    <div id="ErrorHoraFin" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="SelectSala" class="form-label ">Sala</label>
                            <select class="form-select card-input" id="SelectSala" name="SelectSala" required>
                                <option value="">Seleccione..</option>

                            </select>
                            <div id="ErrorSelectSala" class="invalid-feedback"></div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-agregar" id="btnCrearClaseProgramada">Programar Clase
                            </button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-0">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar esta clase?</p>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        id="btnConfirmarEliminar">Eliminar</button>
                </div>

            </div>
        </div>
    </div>

    </div>
    @vite(['resources/css/calendar.css'])
    @include('componentes.modal_exito')
    @include('componentes.modal_error')
    @vite(['resources/js/clases-gestion.js'])



@endsection