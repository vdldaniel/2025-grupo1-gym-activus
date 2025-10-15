@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <div class="d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap flex-shrink-0"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>            <div>
                <h2 class="fw-bold mb-0">Biblioteca de Ejercicios</h2>
                <span class="text-secondary small">Gestiona y organiza todos los ejercicios</span>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 mt-md-0">
            <button class="btn btn-agregar py-2 px-4" data-bs-toggle="modal" data-bs-target="#modalEjercicio">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                <span class="ms-2 small h6">Nuevo Ejercicio</span>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Total Ejercicios</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap "><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>                    </div>
                    <p id="totalSocios" class="display-6 fw-bold mt-4">0</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Grupos Musculares</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-biceps-flexed-icon lucide-biceps-flexed "><path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/><path d="M15 14a5 5 0 0 0-7.584 2"/><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/></svg>                    </div>
                    <p id="totalSocios" class="display-6 fw-bold mt-4">0</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-secondary rounded-2 mt-4 ">
        <div class="card-body">
            <div class="row">
                <h7 class="card-title mb-0">Buscar Ejercicios</h7>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-sm-9 col-12">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text card-input icon-input text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                        </span>
                        <input type="text" id="buscadorEjercicios" class="form-control card-input input-left text-light border-secondary" placeholder="Buscar rutinas por nombre">
                    </div>
                </div>
                <div class="col-sm col-12 row g-2 m-0 p-0">
                
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text card-input icon-input text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-biceps-flexed-icon lucide-biceps-flexed"><path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/><path d="M15 14a5 5 0 0 0-7.584 2"/><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/></svg>                            </span>
                            <select class="form-select card-input input-left small">
                                <option selected>Todos los ejercicos</option>
                                <option value="1">Espalda</option>
                                <option value="2">Piernas</option>
                            </select>
                        </div>
                    
                </div>
            </div> 
        </div>
            <div class="table-responsive p-3">
                <table id="tablaEjercicios" class="table table-striped mt-2 small">
                    <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Ejercicio</th>
                        <th>Musculos</th>
                        <th>Equipo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            Press de Banca
                            <p class="text-secondary small m-0">Ejercicio fundamental para desarrollar el pecho, hombros y tríceps</p>
                        </td>
                        <td>
                        <span class="badge bg-primary-subtle text-primary">Pecho</span>
                        </td>
                        <td>
                            Barra, Banco
                        </td>
                        <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm small" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-pen-icon lucide-user-pen"><path d="M11.5 15H7a4 4 0 0 0-4 4v2"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="7" r="4"/></svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item small" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>                                    
                                Ver
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#modalEjercicioEditar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                                Editar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger small" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>                            
                                Eliminar
                                </a>
                            </li>
                            </ul>
                        </div>
                        </td>
                    </tr>
                    </tbody>
                </table>   
        </div>
    </div>


</div>




    <div class="modal fade" id="modalEjercicio" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitulo">Nuevo Ejercicio</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="formRutina">

                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre del Ejercicio</label>
                            <input type="text" id="nombreRutina" class="form-control card-input" placeholder="Nombre del ejercicio" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcionEjercicio" id="descripcionEjercicio"></textarea>
                        </div>
                        <div class="row g-2">
                        <div class="mb-3 col-12 col-md-6">
                        <label class="form-label">Músculos</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona los músculo</option>
                            <option value="1">Músculo</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                        <label class="form-label">Equipo necesarios</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona el equipo necesario</option>
                            <option value="1">Sin equipo</option>
                            <option value="2">Equipo</option>
                            </select>
                        </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Instrucciones (una por linea)</label>
                            <textarea class="form-control card-input" placeholder="1. Primer paso.." name="descripcion" id="pasosEjercicio"></textarea>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Consejos y Tips</label>
                            <textarea class="form-control card-input" placeholder="Consejos importantes para la correcta ejecución" name="tips" id="descripcionRutina"></textarea>
                        </div>
                

            

                    <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-agregar">Guardar</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="modalEjercicioEditar" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitulo">Editar Ejercicio</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="formRutina">

                        <div class="mb-3 col-12">
                            <label class="form-label">Nombre del Ejercicio</label>
                            <input type="text" id="nombreRutina" class="form-control card-input" placeholder="Nombre del ejercicio" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control card-input" placeholder="Escribe una descripción acá..." name="descripcionEjercicio" id="descripcionEjercicio"></textarea>
                        </div>
                        <div class="row g-2">
                        <div class="mb-3 col-12 col-md-6">
                        <label class="form-label">Músculos</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona los músculo</option>
                            <option value="1">Músculo</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                        <label class="form-label">Equipo necesarios</label>
                            <select class="form-select card-input">
                            <option selected>Selecciona el equipo necesario</option>
                            <option value="1">Sin equipo</option>
                            <option value="2">Equipo</option>
                            </select>
                        </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Instrucciones (una por linea)</label>
                            <textarea class="form-control card-input" placeholder="1. Primer paso.." name="descripcion" id="pasosEjercicio"></textarea>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Consejos y Tips</label>
                            <textarea class="form-control card-input" placeholder="Consejos importantes para la correcta ejecución" name="tips" id="descripcionRutina"></textarea>
                        </div>

                    <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-agregar">Guardar</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
