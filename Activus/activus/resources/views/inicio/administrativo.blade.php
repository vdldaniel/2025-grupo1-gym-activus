@extends('layouts.app')

@section('title', 'Inicio – Administrativo')

@vite(['resources/css/inicios.css', 'resources/js/inicio-administrativo.js'])

@section('content')
  <div class="container py-4 text-light">

    <!-- Encabezado -->
    <div
      class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <div class="d-flex align-items-center gap-3">
        <i class="bi bi-speedometer2 fs-3 text-secondary"></i>
        <div>
          <h2 class="fw-bold mb-0">Inicio – Administrativo</h2>
          <span class="text-secondary small">Panel general de gestión y control del gimnasio</span>
        </div>
      </div>
    </div>

    <div class="row g-4">

      <!-- Total de Socios -->
      <div class="col-12 col-md-6">
        <div class="card  shadow-sm rounded-2 h-100">
          <div class="card-body text-start">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Total de Socios</h6>
              <i class="bi bi-people fs-5 text-secondary opacity-75"></i>
            </div>
            <p id="totalSocios" class="display-4 fw-bold mb-0">
              {{ $totalSocios ?? '--' }}
            </p>
            <p id="variacionSocios" class="card-subtitle text-secondary small">
              {{ $totalSocios ? 'Socios registrados actualmente' : 'No hay socios registrados' }}
            </p>
          </div>
        </div>
      </div>

      <!-- Clases Activas -->
      <div class="col-12 col-md-6">
        <div class="card  shadow-sm rounded-2 h-100">
          <div class="card-body text-start">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Clases Activas</h6>
              <i class="bi bi-journal-check fs-5 text-secondary opacity-75"></i>
            </div>
            <p id="totalClases" class="display-4 fw-bold mb-0">
              {{ $totalClases ?? '--' }}
            </p>
            <p id="variacionClases" class="card-subtitle text-secondary small">
              {{ $totalClases > 0 ? 'Programadas para hoy' : 'No hay clases activas hoy' }}
            </p>
          </div>
        </div>
      </div>

      <!-- Acciones Rápidas -->
      <div class="col-12 col-md-6">
        <div class="card  shadow-sm rounded-2 h-100">
          <div class="card-body text-start">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Acciones Rápidas</h6>
              <i class="bi bi-lightning-charge fs-5 text-secondary opacity-75"></i>
            </div>
            <p class="card-subtitle text-secondary small mb-3">
              Tareas comunes y accesos directos
            </p>
            <!-- btn-outline-light estos botones se ven bien en el fondo oscuro pero en los claros se pierden (podes agregarle la clase btn-agregar o
                                                                                           armate una clase y dales estilos propios  con colore nos tan claros )-->
            <div class="d-grid gap-2">
              <a href="{{ route('ingreso.gimnasio') }}" class="btn btn-dark w-100">
                <i class="bi bi-person-check"></i> Ingreso al Gimnasio
              </a>
              <a href="{{ route('socios.index') }}" class="btn btn-outline-primary-element btn-sm text-start">
                <i class="bi bi-people me-1"></i> Gestionar Socios
              </a>
              <a href="{{ route('clases.gestion') }}" class="btn btn-outline-primary-element btn-sm text-start">
                <i class="bi bi-calendar-plus me-1"></i> Programar Clases
              </a>
              <a href="{{ route('membresias.gestion') }}" class="btn btn-outline-primary-element btn-sm text-start">
                <i class="bi bi-journal-text me-1"></i> Gestionar Membresías
              </a>
              <a href="{{ route('profesores.gestion') }}" class="btn btn-outline-primary-element btn-sm text-start">
                <i class="bi bi-person-badge me-1"></i> Ver Profesores
              </a>
              <a href="{{ route('pagos.index') }}" id="btnPagos"
                class="btn btn-outline-primary-element btn-sm text-start">
                <i class="bi bi-cash-coin me-1"></i> Registro de Pagos
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Horario de Hoy -->
      <div class="col-12 col-md-6">
        <div class="card   shadow-sm rounded-2 h-100">
          <div class="card-body text-start">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="card-title mb-0">Horario de Hoy</h6>
              <i class="bi bi-calendar-event fs-5 text-secondary opacity-75"></i>
            </div>
            <p class="card-subtitle text-secondary small mb-3">Próximas clases y eventos</p>

            <ul id="listaHorarioHoy" class="list-unstyled mb-0">
              @if($clasesHoy->isEmpty())
                <li class="text-secondary small">No hay clases programadas para hoy</li>
              @else
                @foreach($clasesHoy as $clase)
                  <li class="small mb-1">
                    <strong>{{ $clase->Nombre_Clase }}</strong> –
                    {{ \Carbon\Carbon::parse($clase->Hora_Inicio)->format('H:i') }}
                    a {{ \Carbon\Carbon::parse($clase->Hora_Fin)->format('H:i') }}
                    @if($clase->Profesor)
                      <span class="text-secondary">({{ $clase->Profesor }})</span>
                    @endif
                  </li>
                @endforeach
              @endif
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection