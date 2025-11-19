@extends('layouts.app')

@section('content')
<div class="container vista-asistencia py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
        <div class="d-flex align-items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-calendar-check-icon lucide-calendar-check">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
                <path d="m9 16 2 2 4-4" />
            </svg>
            <div>
                <h2 class="fw-bold mb-0">Ingresos Diarios</h2>
                <span class="text-secondary small">Registro de socios que ingresaron hoy</span>
            </div>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="card p-3 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Buscar</label>
                <input type="text" id="buscarAsistencia" class="form-control" placeholder="Nombre, Apellido o DNI">
            </div>

            <div class="col-md-3">
                <label class="form-label">Desde</label>
                <input type="date" id="desdeAsistencia" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Hasta</label>
                <input type="date" id="hastaAsistencia" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label">Tipo Usuario</label>
                <select id="tipoUsuario" class="form-select">
                    <option value="todos">Todos</option>
                    <option value="1">Administrador</option>
                    <option value="2">Profesor</option>
                    <option value="3">Administrativo</option>
                    <option value="4">Socio</option>
                </select>
            </div>
        </div>

        <div class="mt-3 text-end">
            <button id="filtrarAsistencias" class="btn btn-primary">
                <i class="bi bi-search"></i> Filtrar
            </button>
        </div>
    </div>

    <!-- TABLA -->
    <div class="card p-3">
        <table class="table table-striped" id="tablaAsistencias">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

</div>
@endsection

@section('scripts')
    @vite(['resources/js/asistencias.js'])
@endsection
