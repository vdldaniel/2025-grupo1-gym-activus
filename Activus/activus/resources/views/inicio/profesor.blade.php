@extends('layouts.app')

@section('content')
  @vite(['resources/css/inicios.css'])

  <div class="container py-4 ">

    <!-- Encabezado -->
    <div
      class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="icono-seccion d-flex align-items-center justify-content-center">
          <i class="bi bi-briefcase fs-4"></i>
        </div>
        <div>
          <h2 class="fw-bold mb-0">Inicio – Profesor</h2>
          <span class="text-secondary small">Panel general de gestión y control de clases</span>
        </div>
      </div>
    </div>

    <div class="row g-4">

      <!-- Total de Estudiantes -->
      <div class="col-12 col-md-6">
        <div class="card  h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Total de Estudiantes</h6>
              <i class="bi bi-people fs-5 text-secondary opacity-75"></i>
            </div>
            <p id="totalEstudiantes" class="display-4 fw-bold mb-0">–</p>
            <p id="variacionEstudiantes" class="card-subtitle text-secondary small">–</p>
          </div>
        </div>
      </div>

      <!-- Clases Activas -->
      <div class="col-12 col-md-6">
        <div class="card  h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Clases Activas</h6>
              <i class="bi bi-journal-check fs-5 text-secondary opacity-75"></i>
            </div>
            <p id="totalClases" class="display-4 fw-bold mb-0">–</p>
            <p id="variacionClases" class="card-subtitle text-secondary small">–</p>
          </div>
        </div>
      </div>

      <!-- Acciones Rápidas -->
      <div class="col-12 col-md-6">
        <div class="card  h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Acciones Rápidas</h6>
              <i class="bi bi-lightning-charge fs-5 text-secondary opacity-75"></i>
            </div>
            <p class="card-subtitle text-secondary small mb-2">Tareas comunes y accesos directos</p>
            <div class="d-grid gap-2">
              <a href="{{ url('/clases') }}" class="btn btn-outline-light btn-sm text-start">
                <!--se pierde en colores claros-->
                <i class="bi bi-people me-1"></i> Gestionar Clases
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Horario de Hoy -->
      <div class="col-12 col-md-6">
        <div class="card  h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Horario de Hoy</h6>
              <i class="bi bi-calendar-event fs-5 text-secondary opacity-75"></i>
            </div>
            <p class="card-subtitle text-secondary small mb-3">Próximas clases y eventos</p>
            <ul id="listaClasesHoy" class="list-unstyled mb-0"></ul>
          </div>
        </div>
      </div>

    </div>
  </div>

  @vite(['resources/js/inicio-profesor.js'])
@endsection