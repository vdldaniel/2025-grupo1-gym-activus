@extends('layouts.app')
@section('content')
    <div class="container py-4">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                <div>
                    <h2 class="fw-bold mb-0">Profesores</h2>
                    <span class="text-secondary small">Gestiona el equipo de instructores del gimnasio</span>
                </div>
            </div>
        </div>
        <!-- cards metricas -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6>Total Profesores</h6><i class="bi bi-mortarboard text-secondary "></i>
                    </div>
                    <h3 id="totalProfesores">-</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6>Profesores Activos</h6><i class="bi bi-people text-secondary "></i>
                    </div>
                    <h3 id="profesoresActivos">-</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6>Clases Asignadas</h6> <i class="bi bi-calendar4-event text-secondary "></i>
                    </div>
                    <h3 id="clasesAsignadas">-</h3>
                </div>
            </div>
        </div>
        <div class="card p-3 mb-5">
            <h6>Buscar Profesores</h6>
            <div class="search-box position-relative mt-2  mb-2 input-group flex-nowrap">

                <span class="input-group-text card-input icon-input text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </span>
                <input type="text" id="BuscarProfesoresadmin" class="form-control card-input input-left border-secondary"
                    placeholder="Buscar por nombre ...">
            </div>
        </div>

        <div class="row g-4 " id="ListadoProfesoresadmin">


        </div>
        <div class="modal fade" id="modalClasesBase" data-url="{{ route('clases.gestion') }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Clases asignadas</h5>
                        <button type="button" class="btn-close btn-agregar" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="contenidoClasesBase">
                        Cargando...
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources\js\profesores-administrativo.js'])
@endsection