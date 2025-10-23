@extends('layouts.app')

@section('content')
<div class="container py-4 text-light">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div class="d-flex align-items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card">
        <rect width="20" height="14" x="2" y="5" rx="2"/>
        <line x1="2" x2="22" y1="10" y2="10"/>
      </svg>
      <div>
        <h2 class="fw-bold mb-0">Registro de Pagos</h2>
        <span class="text-secondary small">Administra los pagos y transacciones</span>
      </div>
    </div>

    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalPago">
      <i class="bi bi-plus-lg"></i> Registrar Pago
    </button>
  </div>

  {{-- TARJETA PRINCIPAL --}}
  <div class="card bg-dark text-white border-secondary shadow-sm mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
        <h6 class="mb-0">Pagos</h6>
        <select id="filtroTipo" class="form-select form-select-sm bg-dark text-light border-secondary" style="width:auto">
          <option value="hoy">Hoy</option>
          <option value="mes" selected>Este Mes</option>
          <option value="rango">Rango</option>
        </select>
      </div>

      <h2 id="totalCantidad" class="fw-bold display-6 mb-0">0</h2>
      <p id="totalMonto" class="text-secondary small mb-0">$0 recaudados</p>

      {{-- FILTRO RANGO --}}
      <div id="filtroRango" class="row g-2 mt-3 d-none">
        <div class="col-6">
          <input id="fechaDesde" type="date" class="form-control form-control-sm bg-dark text-light border-secondary" placeholder="Desde">
        </div>
        <div class="col-6">
          <input id="fechaHasta" type="date" class="form-control form-control-sm bg-dark text-light border-secondary" placeholder="Hasta">
        </div>
        <div class="col-12">
          <button id="btnFiltrar" class="btn btn-primary btn-sm w-100">Filtrar</button>
        </div>
      </div>
    </div>
  </div>

  {{-- HISTORIAL DE PAGOS --}}
  <div class="card bg-dark text-white border-secondary shadow-sm">
    <div class="card-body">
      <h6 class="card-title mb-2">Historial de Pagos</h6>
      <p class="text-secondary small">Registro completo de transacciones</p>

      <div class="input-group mb-3">
        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-search"></i></span>
        <input id="buscador" type="text" class="form-control bg-dark text-light border-secondary" placeholder="Buscar por socio, ID o DNI...">
      </div>

      <div id="listaPagos" class="list-group"></div>
    </div>
  </div>
</div>

{{-- MODAL REGISTRAR PAGO --}}
<div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light border-secondary">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Pago</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formPago" autocomplete="off">
          @csrf
          <input type="hidden" id="idAdmin" name="idAdmin" value="1">

          {{-- DATOS SOCIO --}}
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label">DNI</label>
              <input type="text" id="dni" name="dni" class="form-control bg-dark text-light border-secondary" placeholder="Buscar por DNI">
            </div>
            <div class="col-6">
              <label class="form-label">ID Socio</label>
              <input type="text" id="idSocio" name="idSocio" class="form-control bg-dark text-light border-secondary" placeholder="Buscar por ID">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Nombre del Socio</label>
            <input type="text" id="socio" name="socio" class="form-control bg-dark text-light border-secondary" readonly>
          </div>

          {{-- MEMBRESÍAS --}}
          <div class="mb-3">
            <label class="form-label">Membresías</label>
            <div id="membresiasContainer" class="d-grid gap-1">
              <p class="text-secondary small mb-0">Se cargarán las membresías disponibles...</p>
            </div>
          </div>

          {{-- FECHAS --}}
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label">Fecha de Pago</label>
              <input type="date" id="fechaPago" name="fechaPago" class="form-control bg-dark text-light border-secondary" readonly>
            </div>
            <div class="col-6">
              <label class="form-label">Fecha de Vencimiento</label>
              <input type="date" id="fechaVencimiento" name="fechaVencimiento" class="form-control bg-dark text-light border-secondary" readonly>
            </div>
          </div>

          {{-- MÉTODO --}}
          <div class="mb-3">
            <label class="form-label">Método de Pago</label>
            <select id="metodo" name="metodo" class="form-select bg-dark text-light border-secondary">
              <option value="Efectivo">Efectivo</option>
              <option value="Tarjeta">Tarjeta</option>
              <option value="Transferencia">Transferencia</option>
              <option value="Otro">Otro</option>
            </select>
          </div>

          {{-- MONTO --}}
          <div class="mb-3">
            <label class="form-label">Monto Total</label>
            <input type="text" id="montoTotal" name="montoTotal" class="form-control bg-dark text-light border-secondary" readonly>
          </div>

          {{-- ESTADO --}}
          <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" id="estado" name="estado" class="form-control bg-dark text-light border-secondary" value="Pagado" readonly>
          </div>

          {{-- OBSERVACIÓN --}}
          <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea id="observacion" name="observacion" class="form-control bg-dark text-light border-secondary" rows="2" placeholder="Opcional: observaciones internas"></textarea>
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Registrar Pago</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- MODAL ÉXITO --}}
<div class="modal fade" id="modalExito" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-success text-white text-center p-4">
      <h5>Pago registrado con éxito</h5>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="{{ asset('js/pagos-admin.js') }}"></script>

{{-- Fallback por si el script no cargó --}}
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const filtroTipo = document.getElementById('filtroTipo');
    const filtroRango = document.getElementById('filtroRango');
    if (!filtroTipo || !filtroRango) return;
    const toggleRango = () => filtroRango.classList.toggle("d-none", filtroTipo.value !== "rango");
    filtroTipo.addEventListener("change", toggleRango);
    toggleRango();
  });
</script>
@endsection
