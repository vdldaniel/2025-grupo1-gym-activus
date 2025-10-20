@extends('layouts.app')
@section('content')
    <div class="container vista-asistencia py-4">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

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
        <div class="card p-3 mb-4">
            <div>
                <h6 class="fw-semibold mb-1">
                    <i class="bi bi-calendar3 me-2"></i><span id="fechaHoy"></span>
                </h6>
                <p class="texto-secundario mb-0 ">Total de ingresos: <span id="totalIngresos">0</span></p>
            </div>
        </div>
        <div class="card p-3">
            <h6 class="fw-semibold mb-1">
                <i class="bi bi-clock me-2"></i>Detalle de Ingresos
            </h6>
            <p class="texto-secundario">Lista de accesos registrados</p>

            <table class="table tabla-asistencia">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tablaAsistencias">

                </tbody>
            </table>
        </div>

    </div>
@endsection