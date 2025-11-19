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
                    <h2 class="fw-bold mb-0">Ver Mis Clases</h2>
                    <span class="text-secondary small">Ve las clases y horarios </span>
                </div>
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
                    <h4 id="metricTotalClases" class="display-6 fw-bold mt-4 mb-0"></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Mis clases de hoy</h6>
                        <div class="text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-clock">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>

                    </div>
                    <h4 id="metricClasesHoy" class="display-6 fw-bold mt-4 mb-0"></h4>
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
            <div class="table-responsive ">
                <h6 class="mb-3">Lista de Clases Programadas</h6>
                <table class="table table-hover mt-3 small">
                    <thead>
                        <tr>
                            <th>Nombre de la Clase</th>
                            <th>Capacidad</th>
                            <th>Sala</th>
                            <th>Fecha</th>
                            <th>Ver Alumnos</th>
                        </tr>
                    </thead>
                    <tbody id="tablaClasesProgramadas">

                    </tbody>
                </table>
            </div>
        </div>



        <!--seccion de clases -->
        <div id="seccionClases" class="card p-3 d-none">
            <div class="table-responsive">
                <h6 class="mb-3">Gestion de Clases </h6>
                <table class="table table-hover small border-round">
                    <thead>
                        <tr>
                            <th>Nombre de la clase</th>
                            <th>Capacidad</th>
                        </tr>
                    </thead>
                    <tbody id="tablaClases">

                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div class="modal fade" id="modalVerAlumnos" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Alumnos inscriptos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul id="listaAlumnos" class="list-group small"></ul>
                </div>
            </div>
        </div>
    </div>




    </div>
    @vite(['resources/js/clases-misclases-profe.js'])
    @vite(['resources/css/calendar.css'])
@endsection