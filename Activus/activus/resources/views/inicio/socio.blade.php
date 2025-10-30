@extends('layouts.app')

@section('content')
<div class="container py-4 text-light">
  <h1 class="mb-4 fw-bold">Hola, Socio</h1>

  <!-- Fila superior (3 tarjetas) -->
  <div class="row g-4 mb-4">
    <!-- Mis clases de hoy -->
    <div class="col-12 col-md-4">
      <div class="card bg-dark text-white shadow-sm rounded-2 h-100">
        <div class="card-body text-start">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">Mis Clases de Hoy</h6>
            <i class="bi bi-journal-check fs-5 text-secondary opacity-75"></i>
          </div>
          <p id="cantidadClasesHoy" class="display-4 fw-bold mb-0"></p>
          <p id="detalleClasesHoy" class="card-subtitle text-secondary small"></p>
        </div>
      </div>
    </div>

    <!-- Próximo pago -->
    <div class="col-12 col-md-4">
      <div class="card bg-dark text-white shadow-sm rounded-2 h-100">
        <div class="card-body text-start">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">Próximo Pago</h6>
            <i class="bi bi-cash-coin fs-5 text-secondary opacity-75"></i>
          </div>
          <p id="diasProximoPago" class="display-4 fw-bold mb-0"></p>
          <p id="fechaProximoPago" class="card-subtitle text-secondary small"></p>
        </div>
      </div>
    </div>

    <!-- Membresía -->
    <div class="col-12 col-md-4">
      <div class="card bg-dark text-white shadow-sm rounded-2 h-100">
        <div class="card-body text-start">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">Membresía</h6>
            <i class="bi bi-award fs-5 text-secondary opacity-75"></i>
          </div>
          <p id="precioMembresia" class="display-4 fw-bold mb-0"></p>
          <p id="tipoMembresia" class="card-subtitle text-secondary small"></p>
          <span id="estadoMembresia" class="badge rounded-pill"></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Fila inferior (Horario de hoy ocupa todo el ancho) -->
  <div class="row g-4">
    <div class="col-12">
      <div class="card bg-dark text-white shadow-sm rounded-2 h-100">
        <div class="card-body text-start">
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

@vite(['resources/css/inicios.css', 'resources/js/inicio-socio.js'])
@endsection