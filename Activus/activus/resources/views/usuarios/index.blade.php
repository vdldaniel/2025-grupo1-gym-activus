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
                <h1 class="fw-bold mb-0">Gestión de Usuarios</h1>
                <span class="text-secondary small">Administra los usuarios del sistema</span>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 mt-md-0">
            <button class="btn btn-agregar py-2 px-4" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" x2="19" y1="8" y2="14"/>
                    <line x1="22" x2="16" y1="11" y2="11"/>
                </svg>
                <span class="ms-2 small h6">Nuevo Usuario</span>
            </button>
        </div>
    </div>


    <div class="row g-4">
        <div class="col-12 col-md-3">
            <div class="card  shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Total Usuarios</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <p id="totalUsuarios" class="display-6 fw-bold mt-4 mb-0">{{ $totalUsuarios }}</p>
                    <small id="totalUsuariosInternos" class="mt-0 text-secondary texto-small-card">Usuarios internos: {{ $totalUsuariosInternos }}</small>
                </div>
            </div> 
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Recepcionistas</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-star-icon lucide-user-star"><path d="M16.051 12.616a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.866l-1.156-1.153a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z"/><path d="M8 15H7a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/></svg>
                    </div>
                    <p id="totalAdministrativos" class="display-6 fw-bold mt-4">{{ $totalAdministrativos }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Profesores</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <p id="totalProfesores" class="display-6 fw-bold mt-4">{{ $totalProfesores }}</p>
                </div>
            </div>
        </div>

        
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-secondary rounded-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h7 class="card-title mb-0">Administrador</h7>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog-icon lucide-user-cog"><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m14.305 16.53.923-.382"/><path d="m15.228 13.852-.923-.383"/><path d="m16.852 12.228-.383-.923"/><path d="m16.852 17.772-.383.924"/><path d="m19.148 12.228.383-.923"/><path d="m19.53 18.696-.382-.924"/><path d="m20.772 13.852.924-.383"/><path d="m20.772 16.148.924.383"/><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/></svg>                    </div>
                    <p id="totalAdministradores" class="display-6 fw-bold mt-4">{{ $totalAdmins }}</p>
                </div>
            </div>
        </div>
    </div> 

    <div class="card shadow-sm border-secondary rounded-2 mt-4">
        <div class="card-body">
            <h7 class="card-title mb-2">Directorio de Usuarios</h7>
            <p class="text-secondary small">Buscar y filtrar usuarios del sistema</p>

            <div class="row g-2 mt-2">
                <div class="col-sm-7 col-12">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text card-input icon-input text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                        </span>
                        <input type="text" id="buscadorUsuarios" class="form-control card-input input-left border-secondary" placeholder="Buscar usuarios por nombre, email, dni o id...">
                    </div>
                </div>
                <div class="col-sm col-12 row g-2 m-0 p-0">
                    <div class="col-6">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text card-input icon-input text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel"><path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/></svg>                        </span>
                            <select id="estadoFiltro" class="form-select card-input input-left">
                                <option value="aEstados" selected>Todos los estados</option>
                                @foreach($estadosUsuario as $eu)
                                <option value="{{ $eu->Nombre_Estado_Usuario }}">{{ $eu->Nombre_Estado_Usuario }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <div class="col-6">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text card-input icon-input text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-search-icon lucide-user-round-search"><circle cx="10" cy="8" r="5"/><path d="M2 21a8 8 0 0 1 10.434-7.62"/><circle cx="18" cy="18" r="3"/><path d="m22 22-1.9-1.9"/></svg>
                        </span>                
                        <select class="form-select card-input input-left" id="rolFiltro">
                            <option value="aRoles" selected>Todos los roles</option>
                            @foreach($roles as $rol)
                            <option value="{{ $rol->Nombre_Rol }}">{{ $rol->Nombre_Rol }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end m-0">
                    <button type="button" class="btn text-secondary small mt-2 p-0 border-0 d-none" id="btnLimpiarFiltro">
                        <small>Limpiar filtros</small>
                    </button>
                </div>
            </div> 
        </div>

                <div class="table-responsive p-3">
                    <table id="tablaUsuarios" class="table table-striped mt-3 small border-round">
                        <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha de Alta</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($usuarios->count())
                            @foreach($usuarios as $u)
                            <tr>
                                
                                <td>{{ $u->ID_Usuario }}</td>
                                <td>
                                    <a href="/usuarios/{{ $u->ID_Usuario }}/perfil" 
                                    class="text-decoration-none text-reset d-flex align-items-center gap-2">
                                        <div class="bg-base rounded-circle d-flex justify-content-center align-items-center"
                                            style="width:30px; height:30px; overflow:hidden;">
                                            @if ($u->Foto_Perfil)
                                                <img src="{{ asset('storage/app/public/' . $u->Foto_Perfil) }}" 
                                                    class="object-fit-cover" 
                                                    style="width:30px; height:30px;" alt="Foto">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="lucide lucide-user">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span>{{ $u->Nombre }} {{ $u->Apellido }}</span>
                                    </a>
                                </td>

                                <td>{{ $u->Email }}</td>
                                <td>{{ $u->DNI }}</td>
                                <td>{{ $u->roles->first()?->Nombre_Rol ?? 'Sin rol' }}</td>
                                <td>
                                    @php
                                        $estado = $estadosUsuario->firstWhere('ID_Estado_Usuario', $u->ID_Estado_Usuario);
                                        $color = match($estado->Nombre_Estado_Usuario ?? '') {
                                            'Activo' => 'success',
                                            'Inactivo' => 'danger',
                                            'Suspendido' => 'warning',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $estado->Nombre_Estado_Usuario ?? 'Desconocido' }}</span>
                                </td>
                                <td>{{ $u->Fecha_Alta ?? 'Desconocido'}}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-acciones" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-pen">
                                                <path d="M11.5 15H7a4 4 0 0 0-4 4v2"/>
                                                <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/>
                                                <circle cx="10" cy="7" r="4"/>
                                            </svg>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end dropdown-acciones">

                                            <li>
                                                <button class="dropdown-item editar-btn dropdown-acciones dropdown-item-acciones" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditarUsuario"
                                                    data-id="{{ $u->ID_Usuario }}"
                                                    data-nombre="{{ $u->Nombre }}"
                                                    data-apellido="{{ $u->Apellido }}"
                                                    data-email="{{ $u->Email }}"
                                                    data-dni="{{ $u->DNI }}"
                                                    data-telefono="{{ $u->Telefono }}"
                                                    data-rol="{{ $u->roles->first()?->ID_Rol }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen me-2">
                                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                                    </svg>
                                                    Editar
                                                </button>
                                            </li>
                                            <li>
                                                <form id="formCambiarEstadoUsuario" method="POST">
                                                    @csrf
                                                    <button type="button"
                                                            class="dropdown-item dropdown-acciones dropdown-item-acciones btn-desactivar"
                                                            data-id="{{ $u->ID_Usuario }}"
                                                            data-estado="{{ $u->ID_Estado_Usuario }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check me-2">
                                                            <path d="m16 11 2 2 4-4"/><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                                        </svg>
                                                        {{ $u->ID_Estado_Usuario == 1 ? 'Desactivar' : 'Activar' }}
                                                    </button>
                                                </form>
                                            </li>

                                            <li>
                                                <button type="button" class="dropdown-item text-danger dropdown-item-acciones" data-bs-target="#modalEliminarUsuario" data-bs-toggle="modal" data-id="{{ $u->ID_Usuario }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 me-2">
                                                        <path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
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
        </div> 


    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header border-0">
            <h5 class="modal-title" id="modalTitulo">Registrar Nuevo Usuario</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div id="modal-body-crear" class="modal-body mt-3 mb-4 p-4">        
            <form id="formUsuario"action="{{ route('usuarios.crear') }}" method="POST">
                @csrf
                <div class="row g-3">
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control card-input" placeholder="Primer nombre..." required>
                            <div class="invalid-feedback" id="error-nombreUsuario"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" id="apellidoUsuario" name="apellidoUsuario" class="form-control card-input" placeholder="Apellido..." required>
                            <div class="invalid-feedback" id="error-apellidoUsuario"></div>
                        </div>
                </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">DNI</label>
                            <input type="text" id="dniUsuario" name="dniUsuario" class="form-control card-input" placeholder="DNI (solo números)" required>
                            <div class="invalid-feedback" id="error-dniUsuario"></div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Telefono</label>
                            <input type="text" id="telefonoUsuario" name="telefonoUsuario" class="form-control card-input" placeholder="Telefono (solo números)" required>
                            <div class="invalid-feedback" id="error-telefonoUsuario"></div>
                        </div>
                        <div class="invalid-feedback" id="error-telefonoUsuario"></div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Email</label>
                            <input type="email" id="emailUsuario" name="emailUsuario" class="form-control card-input" placeholder="Correo Electronico..." required>
                            <div class="invalid-feedback" id="error-emailUsuario"></div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Rol</label>
                            <select class="form-select card-input" id="rolUsuario" name="rolUsuario">
                                <option value="" selected disabled>Selecciona un rol</option>
                                @foreach($roles as $rol)
                                <option value="{{ $rol->ID_Rol }}">{{ $rol->Nombre_Rol }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-rolUsuario"></div>
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


<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content small">
            <div class="modal-header border-0">
            <h5 class="modal-title" id="modalTitulo">Editar Usuario</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body my-4 p-4">        
                <form id="formEditarUsuario" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="idUsuarioEditar" name="idUsuarioEditar">
                <div class="row g-3">
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" id="nombreUsuarioEditar" name="nombreUsuarioEditar" class="form-control card-input" placeholder="Primer nombre...">
                            <div class="invalid-feedback" id="error-nombreUsuarioEditar"></div>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" id="apellidoUsuarioEditar" name="apellidoUsuarioEditar" class="form-control card-input" placeholder="Apellido..." required>
                            <div class="invalid-feedback" id="error-apellidoUsuario"></div>
                        </div>
                </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">DNI</label>
                            <input type="text" id="dniUsuarioEditar" name="dniUsuarioEditar" class="form-control card-input" placeholder="DNI (solo números)" required>
                            <div class="invalid-feedback" id="error-dniUsuarioEditar"></div>
                        </div>

                
                        <div class="mb-3 col-12">
                            <label class="form-label">Teléfono</label>
                            <input type="text" id="telefonoUsuarioEditar" name="telefonoUsuarioEditar" class="form-control card-input" placeholder="Telefono (solo números)" required>
                            <div class="invalid-feedback" id="error-telefonoUsuarioEditar"></div>
                        </div>
                        <div class="invalid-feedback" id="error-telefonoUsuarioEditar"></div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Email</label>
                            <input type="email" id="emailUsuarioEditar" name="emailUsuarioEditar" class="form-control card-input" placeholder="Correo Electronico..." required>
                            <div class="invalid-feedback" id="error-emailUsuarioEditar"></div>
                        </div>
                
                        <div class="mb-4">
                            <label class="form-label">Rol</label>
                            <select class="form-select card-input" id="rolUsuarioEditar" name="rolUsuarioEditar">
                                <option value="" disabled>Selecciona un rol</option>
                                @foreach($roles as $rol)
                                <option value="{{ $rol->ID_Rol }}">{{ $rol->Nombre_Rol }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-rolUsuarioEditar"></div>
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

<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header border-0">
            <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar eliminación de usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro de que desea eliminar este usuario?</p>
        </div>
        <div class="modal-footer border-0">
            <form id="formEliminarUsuario" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </form>
        </div>
        </div>
    </div>
</div>

@vite(['resources/js/usuario.js'])

@include('componentes.modal_exito')



@endsection