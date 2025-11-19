@extends('layouts.app')

@section('content')
<div class="container py-4">

  <!-- ======= TÍTULO ======= -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
    <div class="d-flex align-items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-calendar">
        <path d="M8 2v4" />
        <path d="M16 2v4" />
        <rect width="18" height="18" x="3" y="4" rx="2" />
        <path d="M3 10h18" />
      </svg>

      <div>
        <h2 class="fw-bold mb-0">Clases</h2>
        <span class="text-secondary small">Consulta tus clases o inscríbete en nuevas</span>
      </div>
    </div>
  </div>

  <!-- ======= MÉTRICAS ======= -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card p-3 text-center">
        <h6>Total de clases inscriptas</h6>
        <h4 id="metricTotalClases" class="display-6 fw-bold mt-3 mb-0">0</h4>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 text-center">
        <h6>Clases de hoy</h6>
        <h4 id="metricClasesHoy" class="display-6 fw-bold mt-3 mb-0">0</h4>
      </div>
    </div>
  </div>

  <!-- ======= BOTONES DE SECCIONES ======= -->
  <div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-tab active" id="btnHorario">
      <i class="bi bi-calendar me-2"></i>Vista de Horarios
    </button>
    <button class="btn btn-tab" id="btnInscripcion">
      <i class="bi bi-plus-circle me-2"></i>Inscripción a Clases
    </button>
  </div>

  <!-- ======= CALENDARIO ======= -->
  <div id="seccionHorario" class="card p-3">
    <div id="calendar" class="w-100"></div>
  </div>

  <!-- ======= INSCRIPCIÓN A CLASES ======= -->
  <div id="seccionInscripcion" class="card p-3 d-none">
    <h6 class="mb-3">Inscripción de Clases</h6>
    <div class="table-responsive">
      <table class="table table-hover small align-middle">
        <thead>
          <tr>
            <th>Nombre de la Clase</th>
            <th>Instructor</th>
            <th>Capacidad</th>
            <th>Sala</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaClasesDisponibles">
          <tr>
            <td colspan="6" class="text-center text-secondary py-3">
              Cargando clases...
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Modal único de confirmación / notificación -->
<div class="modal fade" id="modalNotificacion" tabindex="-1" aria-labelledby="modalNotificacionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light border border-secondary rounded-3 shadow-lg">

      <div class="modal-header border-secondary">
        <h5 class="modal-title fw-semibold" id="modalNotificacionLabel">Confirmar inscripción</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body" id="modalNotificacionMensaje">
        ¿Deseas inscribirte a esta clase?
      </div>

      <div class="modal-footer border-secondary d-flex justify-content-end">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-accent" id="btnConfirmarInscripcion">Confirmar</button>
      </div>

    </div>
  </div>
</div>

<!-- ======= ARCHIVOS JS Y CSS ======= -->
@vite([
  'resources/js/clases-socio.js',
  'resources/css/clases-socio.css'
])


@endsection
