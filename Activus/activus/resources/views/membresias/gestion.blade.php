@extends('layouts.app')
@section('content')
    <div id="vista-membresias-admin" class=" container py-4 vista-membresias ">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">

            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-crown-icon lucide-crown">
                    <path
                        d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                    <path d="M5 21h14" />
                </svg>

                <div>
                    <h2 class="fw-bold mb-0">Membresías</h2>
                    <span class="text-secondary small">Gestiona los planes de membresía del gimnasio</span>
                </div>
            </div>

            <div class="d-flex align-items-start align-items-md-center mt-3 mt-md-0">
                <button id="btnNuevaMembresia" class="btn btn-agregar py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                    <span class="ms-2 small h6">Nueva Membresía</span>
                </button>
            </div>

        </div>

        <!-- metricas -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Total Membresías</h6>
                        <i class="fa-solid fa-crown text-secondary small"></i>
                    </div>
                    <h4 id="metricTotalMembresias">-</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Miembros Totales</h6>
                        <i class="bi bi-people text-secondary"></i>
                    </div>
                    <h4 id="metricTotalMiembros">-</h4>

                </div>
            </div>

        </div>



        <div id="cardMembresias" class="card p-3">
            <h6 class="mb-3">Lista de Membresías</h6>
            <table class="table ">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Duración</th>
                        <th>Miembros</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody id="tablamembresias-admin">

                </tbody>
            </table>
        </div>


    </div>
    <!-- modal con formulario para ingresar una nueva membresia o editar   -->
    <div class="modal fade" id="modalMembresia" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Nueva Membresía</h5>

                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formMembresia">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="NombreMembresia" class="form-label">Nombre</label>
                                <input type="text" class="form-control card-input" placeholder="Ej: Básica, Premium"
                                    id="NombreMembresia" name="NombreMembresia" required>
                                <div class="valid-feedback"></div>
                                <div id="ErrorNombreMembresia" class="invalid-feedback"></div>
                            </div>
                            <div class="col">
                                <label for="PrecioMembresia" class="form-label">Precio (ARS)</label>
                                <input type="number" class="form-control card-input" placeholder="15000"
                                    id="PrecioMembresia" name="PrecioMembresia" required>
                                <div class="valid-feedback"></div>
                                <div id="ErrorPrecioMembresia" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="DuracionMembresia" class="form-label">Duración</label>
                                <input type="number" class="form-control card-input" placeholder="30" id="DuracionMembresia"
                                    name="DuracionMembresia" required>
                                <div class="valid-feedback"></div>
                                <div id="ErrorDuracionMembresia" class="invalid-feedback"></div>
                            </div>

                            <div class="col-6">
                                <label for="UnidadDuracion" class="form-label ">Unidad</label>
                                <select class="form-select card-input" id="UnidadDuracion" name="UnidadDuracion" required>
                                    <option value="">Seleccione..</option>
                                    <option value="meses">Meses</option>
                                    <option value="días">Días</option>
                                    <option value="semanas">Semanas</option>
                                    <option value="años">Años</option>
                                </select>
                                <div class="valid-feedback"></div>
                                <div id="ErrorUnidadDuracion" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="DescripcionMembresia" class="form-label">Descripción</label>
                            <textarea class="form-control card-input" rows="2"
                                placeholder="Describe los beneficios principales" id="DescripcionMembresia"
                                name="DescripcionMembresia" required></textarea>
                            <div class="valid-feedback"></div>
                            <div id="ErrorDescripcionMembresia" class="invalid-feedback"></div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-agregar" id="btnCrearMembresia">Crear
                                Membresía</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalConfirmarEliminarMembresia" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-0">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar esta membresía?</p>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        id="btnConfirmarEliminarMembresia">Eliminar</button>
                </div>

            </div>
        </div>
    </div>
    @include('componentes.modal_exito')
    @include('componentes.modal_error')
    @vite(['resources/js/membresias-administrativo.js'])
@endsection