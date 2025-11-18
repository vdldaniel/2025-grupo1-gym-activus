@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <div class="d-flex align-items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-users flex-shrink-0">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <circle cx="9" cy="7" r="4" />
            </svg>

            <div>
                <h2 class="fw-bold mb-0">Gestión de Socios</h2>
                <span class="text-secondary small">Administra los socios del gimnasio</span>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 mt-md-0">
            <button class="btn btn-agregar py-2 px-4" data-bs-toggle="modal" data-bs-target="#modalSocio">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <line x1="19" x2="19" y1="8" y2="14" />
                    <line x1="22" x2="16" y1="11" y2="11" />
                </svg>
                <span class="ms-2 small h6">Nuevo Socio</span>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-4 ">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Total Socios</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users ">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                    </div>
                    <p id="totalSocios" class="display-6 fw-bold mt-4">{{ $totalSocios }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4  ">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Socios Activos</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check-icon lucide-user-check">
                            <path d="m16 11 2 2 4-4" />
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                    </div>
                    <p id="totalSociosActivos" class="display-6 fw-bold mt-4">{{ $totalSociosActivos }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 ">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Nuevos Este Mes</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" x2="19" y1="8" y2="14" />
                            <line x1="22" x2="16" y1="11" y2="11" />
                        </svg>
                    </div>
                    <p id="totalSociosNuevosMes" class="display-6 fw-bold mt-4">{{ $totalSociosNuevosMes }}</p>
                </div>
            </div>
        </div>

    </div>
    <!-- NAV TABS -->
    <ul class="nav nav-tabs mt-4" id="socioTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-directorio" data-bs-toggle="tab"
                data-bs-target="#panel-directorio" type="button" role="tab">
                Directorio de Socios
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-ingresos" data-bs-toggle="tab"
                data-bs-target="#panel-ingresos" type="button" role="tab">
                Ingresos de Socios
            </button>
        </li>
    </ul>
    <div class="tab-content" id="sociosTabsContent">

        <!-- PANEL 1 - DIRECTORIO -->
        <div class="tab-pane fade show active" id="panel-directorio" role="tabpanel">
            <div class="card shadow-sm border-secondary rounded-2 mt-4 ">
                <div class="card-body">
                    <div class="row">
                        <h7 class="card-title mb-0">Directorio de Socios</h7>
                        <span class="text-secondary small">Buscar y filtrar socios del gimnasio</span>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-sm-7 col-12">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text card-input icon-input text-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
                                        <path d="m21 21-4.34-4.34" />
                                        <circle cx="11" cy="11" r="8" />
                                    </svg>
                                </span>
                                <input type="text" id="buscadorSocios" class="form-control card-input input-left text-light border-secondary" placeholder="Buscar socios por nombre, email, dni o id...">
                            </div>
                        </div>
                        <div class="col-sm col-12 row g-2 m-0 p-0">
                            <div class="col-6">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text card-input icon-input text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel">
                                            <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                                        </svg> </span>
                                    <select id="estadoMembresiaFiltro" class="form-select card-input input-left small">
                                        <option value="aEstadosMembresia" selected>Todos los estados</option>
                                        @foreach($estadosMembresiaSocio as $em)
                                        <option value="{{ $em->Nombre_Estado_Membresia_Socio }}">{{ $em->Nombre_Estado_Membresia_Socio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text card-input icon-input text-secondary small">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-crown-icon lucide-crown">
                                            <path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                                            <path d="M5 21h14" />
                                        </svg> </span>
                                    <select id="membresiaFiltro" class="form-select card-input input-left">
                                        <option value="aMembresias" selected>Todas las membresias</option>
                                        @foreach($membresias as $m)
                                        <option value="{{ $m->Nombre_Tipo_Membresia }}">{{ $m->Nombre_Tipo_Membresia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end m-0">
                                <button type="button" class="btn text-secondary small mt-2 p-0 border-0 d-none" id="btnLimpiarFiltro">
                                    <small>Limpiar filtros</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive p-3">
                    <table id="tablaSocios" class="table table-striped mt-3 small border-round">
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Contacto</th>
                                <th>Membresia</th>
                                <th>Estado Membresia</th>
                                <th>Vence</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($socios->count())
                            @foreach($socios as $s)
                            <tr>
                                <td>{{ $s->usuario->ID_Usuario }}</td>
                                <td> <a href="{{ route('usuarios.perfil', $s->usuario->ID_Usuario) }}" class="me-3 text-decoration-none">
                                        <img src="{{ $s->usuario->Foto_Perfil ?? 'images/default/profile-default.jpg' }}" class="rounded-circle" alt="Foto de {{ $s->usuario->Nombre }}" width="28" height="28">
                                    </a>
                                    {{ $s->usuario->Nombre }} {{ $s->usuario->Apellido }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card">
                                            <path d="M16 10h2" />
                                            <path d="M16 14h2" />
                                            <path d="M6.17 15a3 3 0 0 1 5.66 0" />
                                            <circle cx="9" cy="11" r="2" />
                                            <rect x="2" y="5" width="20" height="14" rx="2" />
                                        </svg>
                                        {{ $s->usuario->DNI }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail">
                                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                            <rect x="2" y="4" width="20" height="16" rx="2" />
                                        </svg>
                                        {{ $s->usuario->Email }}
                                    </div>
                                    <div class="d-flex align-items-center gap-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
                                            <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                        </svg>
                                        {{ $s->usuario->Telefono }}
                                    </div>
                                </td>

                                <td>
                                    @php
                                    $membresia = $s->membresias->first();
                                    @endphp
                                    @if ($membresia)
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $membresia->Nombre_Tipo_Membresia }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">Sin membresía</span>
                                    @endif
                                </td>

                                <td>
                                    @php
                                    $membresia = $s->membresiaSocio->first();
                                    $estado = $membresia?->estadoMembresiaSocio?->Nombre_Estado_Membresia_Socio;
                                    $color = match($estado ?? '') {
                                    'Activa' => 'success',
                                    'Vencida' => 'danger',
                                    'Pendiente' => 'warning',
                                    default => 'secondary'
                                    };
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $estado ?? 'Desconocido' }}</span>
                                </td>

                                <td>
                                    @php
                                    $membresia = $s->membresiaSocio->first();
                                    $fecha = $membresia?->Fecha_Fin ?? 'Sin membresía';
                                    @endphp

                                    {{ $fecha }}
                                </td>

                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-acciones" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-pen">
                                                <path d="M11.5 15H7a4 4 0 0 0-4 4v2" />
                                                <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                                <circle cx="10" cy="7" r="4" />
                                            </svg>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end dropdown-acciones">

                                            <li>
                                                <button class="dropdown-item editar-btn dropdown-acciones dropdown-item-acciones" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditarSocio"
                                                    data-id="{{ $s->usuario->ID_Usuario}}"
                                                    data-nombre="{{ $s->usuario->Nombre }}"
                                                    data-apellido="{{ $s->usuario->Apellido }}"
                                                    data-email="{{ $s->usuario->Email }}"
                                                    data-dni="{{ $s->usuario->DNI }}"
                                                    data-telefono="{{ $s->usuario->Telefono }}"
                                                    data-fecha-nacimiento="{{ $s->Fecha_Nacimiento }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen me-2">
                                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                                    </svg>
                                                    Editar
                                                </button>
                                            </li>

                                            <li>
                                                <button type="button" class="dropdown-item text-danger dropdown-item-acciones" data-bs-target="#modalEliminarSocio" data-bs-toggle="modal" data-id="{{ $s->usuario->ID_Usuario }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 me-2">
                                                        <path d="M10 11v6" />
                                                        <path d="M14 11v6" />
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                        <path d="M3 6h18" />
                                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                    Eliminar
                                                </button>

                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="modal fade" id="modalSocio" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content small">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitulo">Registrar Nuevo Socio</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formSocio" action="{{ route('socios.crear') }}" method="POST">
                                @csrf
                                <div class="row g-2">
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" id="nombreSocio" name="nombreSocio" class="form-control card-input" placeholder="Primer nombre del socio...">
                                        <div class="invalid-feedback" id="error-nombreSocio"></div>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" id="apellidoSocio" name="apellidoSocio" class="form-control card-input" placeholder="Apellido del socio...">
                                        <div class="invalid-feedback" id="error-apellidoSocio"></div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">DNI</label>
                                        <input type="text" id="dniSocio" name="dniSocio" class="form-control card-input" placeholder="DNI (solo números)">
                                        <div class="invalid-feedback" id="error-dniSocio"></div>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" id="fechaNacSocio" name="fechaNacSocio" class="form-control card-input" placeholder="dd/mm/aaaa">
                                        <div class="invalid-feedback" id="error-fechaNacSocio"></div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" id="telefonoSocio" name="telefonoSocio" class="form-control card-input" placeholder="Teléfono (solo números)">
                                        <div class="invalid-feedback" id="error-telefonoSocio"></div>
                                    </div>
                                    <div class="mb-3 col-12 col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" id="emailSocio" name="emailSocio" class="form-control card-input" placeholder="Correo Electrónico...">
                                        <div class="invalid-feedback" id="error-emailSocio"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Membresía</label>
                                    <select id="membresiaSocio" class="form-select card-input" name="membresiaSocio">
                                        <option selected value="" disabled>Selecciona una membresía</option>
                                        @foreach($membresias as $m)
                                        <option value="{{ $m->ID_Tipo_Membresia }}">{{ $m->Nombre_Tipo_Membresia }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="error-membresiaSocio"></div>
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


        <!-- PANEL 2 - INGRESOS -->
        <div class="tab-pane fade" id="panel-ingresos" role="tabpanel">

            <div class="card shadow-sm border-secondary rounded-2">
                <div class="card-body">
                    <div class="row">
                        <h7 class="card-title mb-0">Ingresos de Socios</h7>
                        <span class="text-secondary small">Registro de ingreso al gimnasio</span>
                    </div>

                    <!-- FILTROS -->
                    <div class="row g-2 mt-2">

                        <!-- BUSCADOR (misma estética que Directorio) -->
                        <div class="col-sm-4">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text card-input icon-input text-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-search">
                                        <path d="m21 21-4.34-4.34" />
                                        <circle cx="11" cy="11" r="8" />
                                    </svg>
                                </span>
                                <input type="text" id="buscarIngreso"
                                    class="form-control card-input input-left text-light border-secondary"
                                    placeholder="Buscar por nombre, DNI o ID...">
                            </div>
                        </div>



                        <!-- FECHA DESDE/HASTA igual estética -->
                        <div class="col-sm-3 mt-2">
                            <input type="date" id="fechaDesde"
                                class="form-control card-input" placeholder="Desde...">
                            <label for="desde" class="text-secondary small"> Desde</label>
                        </div>

                        <div class="col-sm-3 mt-2">
                            <input type="date" id="fechaHasta"
                                class="form-control card-input" placeholder="Hasta...">
                            <label for="hasta" class="text-secondary small"> Hasta</label>
                        </div>

                        <!-- BOTÓN FILTRAR -->
                        <div class="col-sm-2 mt-2">
                            <button class="btn btn-secondary w-100" id="filtrarIngresos">
                                Filtrar
                            </button>
                        </div>

                        <!-- BOTÓN LIMPIAR (igual que Directorio) -->
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn text-secondary small p-0 border-0 d-none"
                                id="btnLimpiarFiltroIngresos">
                                <small>Limpiar filtros</small>
                            </button>
                        </div>

                    </div> <!-- row filtros -->

                </div>

                <!-- TABLA INGRESOS -->
                <div class="table-responsive p-3">
                    <table id="tablaIngresos" class="table table-striped mt-3 small border-round">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>
                                    <a href="{{ route('socios.index', ['sort' => 'nombre', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                        Nombre
                                        @if(request('sort') === 'nombre')
                                        @if(request('direction') === 'asc')
                                        ▲
                                        @else
                                        ▼
                                        @endif
                                        @endif
                                    </a>
                                </th>

                                <th>DNI</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($ingresos as $i)
                            <tr>
                                <td>{{ $i->ID_Socio }}</td>
                                <td>{{ $i->Nombre }} {{ $i->Apellido }}</td>
                                <td>{{ $i->DNI }}</td>
                                <td>{{ $i->Fecha }}</td>
                                <td>{{ $i->Hora }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="modalEditarSocio" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitulo">Editar Socio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarSocio" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="idSocioEditar" name="idSocioEditar">
                    <div class="row g-2">
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" id="nombreSocioEditar" class="form-control card-input" placeholder="Primer nombre del socio..." name="nombreSocioEditar">
                            <div class="invalid-feedback" id="error-nombreSocioEditar"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" id="apellidoSocioEditar" class="form-control card-input" placeholder="Apellido del socio..." name="apellidoSocioEditar">
                            <div class="invalid-feedback" id="error-apellidoSocioEditar"></div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">DNI</label>
                            <input type="text" id="dniSocioEditar" class="form-control card-input" placeholder="DNI (solo números)" name="dniSocioEditar">
                            <div class="invalid-feedback" id="error-dniSocioEditar"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="date" id="fechaNacSocioEditar" class="form-control card-input" placeholder="dd/mm/aaaa" name="fechaNacSocioEditar">
                            <div class="invalid-feedback" id="error-fechaNacSocioEditar"></div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Telefono</label>
                            <input type="text" id="telefonoSocioEditar" class="form-control card-input" placeholder="Telefono (solo números)" name="telefonoSocioEditar">
                            <div class="invalid-feedback" id="error-telefonoSocioEditar"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="mail" id="emailSocioEditar" class="form-control card-input" placeholder="Correo Electronico..." name="emailSocioEditar">
                            <div class="invalid-feedback" id="error-emailSocioEditar"></div>
                        </div>
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


<div class="modal fade" id="modalEliminarSocio" tabindex="-1" aria-labelledby="modalEliminarSocioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar eliminación de socio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este socio?</p>
            </div>
            <div class="modal-footer border-0">
                <form id="formEliminarSocio" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('componentes.modal_exito')


@endsection