@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <main class="flex-grow-1">
            <header class="p-4">
                <div class="d-flex align-items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <div>
                        <h1 class="fw-bold mb-0">Mi Perfil</h1>
                        <small class="text-secondary small">Gestiona tu información personal</small>
                    </div>
                </div>
            </header>

            <div class="container-fluid px-4">

                @if($rolId === 4)
                <!-- Próximo Pago -->
                <div class="col-lg-12 mb-4">
                    <div class="card bg-card text-light shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Próximo Pago</h6>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card">
                                <rect width="20" height="14" x="2" y="5" rx="2" />
                                <line x1="2" x2="22" y1="10" y2="10" />
                            </svg>
                        </div>
                        <div class="card-body">
                            @if($membresia)
                            <h3 class="fw-bold">
                                @if($diasRestantes > 0)
                                {{intval($diasRestantes) }} días
                                @elseif($diasRestantes === 0)
                                Hoy vence
                                @else
                                Vencido hace {{ abs($diasRestantes) }} días
                                @endif
                            </h3>

                            <p class="text-secondary small mb-2">
                                Vencimiento: {{ $vencimiento }}
                            </p>

                            @if($diasRestantes > 0)
                            <span class="badge bg-success bg-opacity-25 text-success border border-success">Al día</span>
                            @else
                            <span class="badge bg-danger bg-opacity-25 text-danger border border-danger">Vencido</span>
                            @endif
                            @else
                            <p class="text-secondary mb-0">Sin membresía activa</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="row g-4">
                    <!-- Información Personal -->
                    <div class="col-lg-8">
                        <div class="card bg-card text-light shadow-sm">

                            <div class="card-body">
                                <form id="editPerfil" action="{{ route('usuarios.enviarEdicion', $usuario->ID_Usuario) }}" method="POST">
                                    @csrf
                                    @method('PUT') {{-- Porque es una actualización --}}

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="firstName">Nombre</label>
                                            <input type="text" id="firstName" name="Nombre" class="form-control"
                                                value="{{ old('Nombre', $usuario->Nombre) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="lastName">Apellido</label>
                                            <input type="text" id="lastName" name="Apellido" class="form-control"
                                                value="{{ old('Apellido', $usuario->Apellido) }}">
                                        </div>
                                    </div>

                                    @if($rolId === 4)
                                    <div class="mt-3">
                                        <label class="form-label" for="scheduleDate">Fecha Nacimiento</label>
                                        <input type="date" id="scheduleDate" name="Fecha_Nacimiento" class="form-control"
                                            value="{{ old('Fecha_Nacimiento', $socio->Fecha_Nacimiento) }}">
                                    </div>
                                    @endif

                                    <div class="mt-3">
                                        <label class="form-label" for="phone">Teléfono</label>
                                        <input type="text" id="phone" name="Telefono" class="form-control"
                                            value="{{ old('Telefono', $usuario->Telefono ?? '') }}">
                                    </div>

                                    <!-- Botones -->
                                    <div class="d-flex justify-content-end gap-3 mt-4">
                                        <a href="{{ route('usuarios.perfil', $usuario->ID_Usuario) }}" class="btn btn-outline-light">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    @if($rolId === 1)
                    @include('usuarios.perfil_admin')
                    @elseif($rolId === 2)
                    @include('usuarios.perfil_profesor')
                    @elseif($rolId === 3)
                    @include('usuarios.perfil_recepcionista')
                    @elseif($rolId === 4)
                    @include('usuarios.perfil_socio')
                    @endif

                </div>

            </div>
        </main>
    </div>
</div>
@endsection