@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <main class="flex-grow-1">
            <header class="p-4">
                <div class="d-flex align-items-center gap-3">
                    <i data-lucide="users" class="text-primary"></i>
                    <div>
                        <h1 class="fw-bold mb-0">Mi Perfil</h1>
                        <small class="text-secondary small">Gestiona tu información personal</small>
                    </div>
                </div>
            </header>

            <div class="container-fluid px-4">

                @if($rolId === 4)
                <!-- Próximo Pago -->
                <div class="col-lg-12  mb-4">
                    <div class="card bg-card text-light shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Próximo Pago</h6>
                            <i data-lucide="credit-card" class="text-muted"></i>
                        </div>
                        <div class="card-body">
                            <h3 class="fw-bold">7 días</h3>
                            <p class="text-secondary small mb-2">Vencimiento: 17/09/2025</p>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success">Al
                                día</span>
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