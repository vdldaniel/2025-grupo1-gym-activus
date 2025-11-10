@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

            <main class="flex-grow-1">
                <header class="p-4">
                    <div class="d-flex align-items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-icon lucide-user">
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
                            <div class="card bg-card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Próximo Pago</h6>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card">
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
                                            <span class="badge bg-success bg-opacity-25 text-success border border-success">Al
                                                día</span>
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
                            <div class="card bg-card  shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Información Personal</h5>
                                        <small class="text-secondary small mb-2">Gestiona tu información de perfil</small>
                                    </div>
                                    <a href="{{ route('usuarios.editarPerfil', ['id' => $usuario->ID_Usuario]) }}"
                                        class="btn btn-outline-primary btn-sm position-absolute top-0 end-0 m-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path
                                                d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                        </svg>Editar
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <strong class="">Nombre</strong>
                                            <p class="mb-1 small">{{ $usuario->Nombre }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong class="">Apellido</strong>
                                            <p class="mb-1 small">{{ $usuario->Apellido }}</p>
                                        </div>
                                    </div>
                                    @if($rolId === 4)
                                        <div class="mt-3">
                                            <strong class="">Fecha Nacimiento</strong>
                                            <p class="mb-1 small">{{ $socio->Fecha_Nacimiento }}</p>
                                        </div>
                                    @endif
                                    <div class="mt-3">
                                        <strong class="">Correo Electrónico</strong>
                                        <p class="mb-1 small">{{ $usuario->Email }}</p>
                                    </div>

                                    <div class="mt-3">
                                        <strong class="">Teléfono</strong>
                                        <p class="mb-1 small">{{ $usuario->Telefono }}</p>
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