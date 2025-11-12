@extends('layouts.app')

@section('content')
<div class="container py-4 text-light">

  <!-- Encabezado -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div class="d-flex align-items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
           fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
           stroke-linejoin="round" class="lucide lucide-credit-card">
        <rect width="20" height="14" x="2" y="5" rx="2"/>
        <line x1="2" x2="22" y1="10" y2="10"/>
      </svg>
      <div>
        <h2 class="fw-bold mb-0">Pagos</h2>
        <span class="text-secondary small">Consulta tus pagos y vencimientos</span>
      </div>
    </div>
  </div>

  <!-- Sección Membresía y Próximo Pago -->
  <div class="row g-3 mb-4">
    <!-- Membresía -->
    <div class="col-md-6">
      <div class="card  border-secondary h-100">
        <div class="card-body">
          <h5 class="card-title mb-3">Membresía</h5>
          <p class="mb-1 text-secondary">Precio:</p>
          <p id="precioMembresia" class="h5 fw-bold mb-2 text-accent">$0</p>

          <p class="mb-1 text-secondary">Tipo:</p>
          <p id="tipoMembresia" class="h5 fw-bold mb-2">-</p>

          <p class="mb-1 text-secondary">Estado:</p>
          <span id="estadoMembresia" class="badge bg-secondary px-3 py-2">Sin datos</span>
        </div>
      </div>
    </div>

    <!-- Próximo Pago -->
    <div class="col-md-6">
      <div class="card  border-secondary h-100 text-center">
        <div class="card-body">
          <h5 class="card-title mb-3">Próximo Pago</h5>
          <p id="diasRestantes" class="display-5 mb-1 text-accent">--</p>
          <small id="fechaVencimiento" class="text-secondary">Sin datos</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Historial de Pagos -->
  <div class="card  border-secondary">
    <div class="card-body">
      <h5 class="card-title">Historial de Pagos</h5>
      <p class="text-secondary small mb-3">Registro completo de tus transacciones</p>

      <!-- Filtro -->
      <div class="row g-2 mb-3">
        <div class="col-md-4">
          <input type="date" id="fechaDesde" class="form-control  text-light border-secondary" placeholder="Desde">
        </div>
        <div class="col-md-4">
          <input type="date" id="fechaHasta" class="form-control  text-light border-secondary" placeholder="Hasta">
        </div>
        <div class="col-md-4 text-md-end">
          <button id="btnFiltrar" class="btn btn-outline-light w-100 w-md-auto">Filtrar</button>
        </div>
      </div>

      <!-- Lista -->
      <div id="listaPagos" class="list-group list-group-flush">
        <div class="text-secondary text-center py-3">Cargando información...</div>
      </div>
    </div>
  </div>

</div>

@vite(['resources/css/pagos.css', 'resources/js/pagos-socio.js'])
@endsection
