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
                <!-- Tarjeta: Próximo Pago -->
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
                                        <p class="text-light">Nombre</p>
                                        <p class="mb-1 small">{{ $socio->usuario->Nombre }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-light">Apellido</p>
                                        <p class="mb-1 small">{{ $socio->usuario->Apellido }}</p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <p class="text-light">Fecha Nacimiento</p>
                                    <p class="mb-1 small">{{ $socio->Fecha_Nacimiento }}</p>
                                </div>

                                <div class="mt-3">
                                    <p class="text-light">Correo Electrónico</p>
                                    <p class="mb-1 small">{{ $socio->usuario->Email }}</p>
                                </div>

                                <div class="mt-3">
                                    <p class="text-light">Teléfono</p>
                                    <p class="mb-1 small">{{ $socio->usuario->Telefono }}</p>
                                </div>

                                <div class="mt-3">
                                    <p class="text-light">Dirección</p>
                                    <p class="mb-1 small">{{ $socio->usuario->Dirección }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna lateral -->
                    <div class="col-lg-4 d-flex flex-column gap-3">
                        <!-- Resumen del Perfil -->
                        <div class="card bg-card text-light shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Resumen del Perfil</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center"
                                        style="width:64px; height:64px;">
                                        <i data-lucide="user" class="text-light"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $socio->usuario->Nombre }} {{ $socio->usuario->Apellido }}</p>
                                        <span class="badge bg-primary bg-opacity-25 text-primary border border-primary">
                                            <i data-lucide="crown" class="me-1"></i> Básico
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i data-lucide="mail" class="text-muted"></i>
                                        <span class="small">socio1@gym.com</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2"><i data-lucide="calendar"
                                            class="text-muted"></i> <span class="small">Miembro desde: {{ $socio->usuario->Fecha_Alta }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuración de Cuenta -->
                        <div class="card bg-card text-light shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Configuración de Cuenta</h5>
                            </div>
                            <div class="card-body d-flex flex-column gap-2">
                                <button class="btn btn-outline-light btn-sm custom-btn">Cambiar Correo</button>
                                <button class="btn btn-outline-light btn-sm custom-btn">Cambiar Contraseña</button>
                                <button class="btn btn-outline-light btn-sm custom-btn">Subir Certificado</button>
                                <button class="btn btn-danger btn-sm">Cerrar sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>    
@endsection