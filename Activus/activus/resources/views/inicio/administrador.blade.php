@extends('layouts.app')

@section('content')
  @vite(['resources/css/inicios.css'])

  <div class="container py-4 ">
    <!-- Encabezado -->
    <div
      class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="icono-seccion d-flex align-items-center justify-content-center">
          <i class="bi bi-person-gear fs-4"></i>
        </div>
        <div>
          <h2 class="fw-bold mb-0">Inicio – Administrador</h2>
          <span class="text-secondary small">Panel general de gestión del gimnasio</span>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Total de Usuarios -->
      <div class="col-12 col-md-6">
        <div class="card  h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Total de Usuarios</h6>
              <i class="bi bi-people fs-5 text-secondary opacity-75"></i>
            </div>
            <p id="totalUsuarios" class="display-4 fw-bold mb-0">–</p>
            <p id="descripcionUsuarios" class="card-subtitle text-secondary small">–</p>
          </div>
        </div>
      </div>

      <!-- Acciones Rápidas -->
      <div class="col-12 col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Acciones Rápidas</h6>
              <i class="bi bi-lightning-charge fs-5 text-secondary opacity-75"></i>
            </div>
            <p class="card-subtitle text-secondary small mb-2">Tareas comunes y accesos directos</p>
            <div class="d-grid gap-2">
              <a href="{{ url('/usuarios') }}" class="btn btn-outline-primary-element btn-sm text-start">
                <i class="bi bi-person-gear me-1"></i> Gestionar Usuarios
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @vite(['resources/js/inicio-admin.js'])
@endsection