@extends('layouts.app')
@section('content')
    <div id="vistaSala" class="container py-4">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-house-plus-icon lucide-house-plus">
                    <path
                        d="M12.35 21H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 .71-1.53l7-6a2 2 0 0 1 2.58 0l7 6A2 2 0 0 1 21 10v2.35" />
                    <path d="M14.8 12.4A1 1 0 0 0 14 12h-4a1 1 0 0 0-1 1v8" />
                    <path d="M15 18h6" />
                    <path d="M18 15v6" />
                </svg>
                <div>
                    <h2 class="fw-bold mb-0">Salas</h2>
                    <span class="text-secondary small">Administra las salas del gimnasio</span>
                </div>
            </div>

            <div class="d-flex align-items-start align-items-md-center mt-3 mt-md-0">
                <button id="btnNuevaSala" class="btn btn-agregar py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                    <span class="ms-2 small h6">Nueva Sala</span>
                </button>
            </div>

        </div>


        <div id="cardSalas" class="card p-3">
            <h6>Lista de Salas</h6>
            <small class="text-secondary">Administra todas las salas disponibles</small>
            <table class="table  table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody id="tablaSalas">

                </tbody>
            </table>
        </div>

    </div>
    <div class="modal fade" id="modalSala" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Nueva Sala</h5>

                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formSala">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="NombreSala" class="form-label">Nombre</label>
                                <input type="text" class="form-control card-input" placeholder="Ej: Sala A" id="NombreSala"
                                    name="NombreSala">
                                <div class="valid-feedback"></div>
                                <div id="ErrorNombreSala" class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-agregar" id="btnCrearSala">Crear Sala</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalConfirmarEliminarSala" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-0">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar esta sala?</p>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        id="btnConfirmarEliminarSala">Eliminar</button>
                </div>

            </div>
        </div>
    </div>
    @include('componentes.modal_exito')
    @include('componentes.modal_error')
    @vite(['resources\js\salas.js'])
@endsection