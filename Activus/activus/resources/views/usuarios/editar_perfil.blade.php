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
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">Información Personal</h5>
                                    <small class="text-secondary small mb-2">Gestiona tu información de perfil</small>
                                </div>
                                <a href="editar-perfil-socio.html"
                                    class="btn btn-outline-primary btn-sm position-absolute top-0 end-0 m-2">
                                    <i data-lucide="edit" class="me-1"></i>Editar
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="firstName">Nombre</label>
                                        <input type="text" id="firstName" class="form-control"
                                            value="Mi Nombre">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="lastName">Apellido</label>
                                        <input type="text" id="lastName" class="form-control"
                                            value="Mi Apellido">
                                    </div>
                                </div>
                                @if($rolId === 4)
                                <div class="mt-3">
                                    <label class="form-label" for="scheduleDate">Fecha
                                        Nacimiento</label>
                                    <input type="date" id="scheduleDate" class="form-control"
                                        value="1990-01-01">
                                </div>
                                @endif
                                <div class="mt-3">
                                    <label class="form-label" for="email">Correo Electrónico</label>
                                    <input type="email" id="email" class="form-control"
                                        value="micorreo@gym.com">
                                </div>

                                <div class="mt-3">
                                    <label class="form-label" for="phone">Teléfono</label>
                                    <input type="text" id="phone" class="form-control"
                                        value="+54 11 1234-5678">
                                </div>
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