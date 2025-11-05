@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">


            <main class="flex-grow-1 p-4">
                <div class="d-flex align-items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-map-pin-icon lucide-map-pin">
                        <path
                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <div>
                        <h2 class="fw-bold mb-0">Dónde entrenar</h2>
                        <span class="text-secondary small">Ubicaciones y horarios</span>
                    </div>
                </div>
                <div class="container">

                    <div class="card card-body">
                        <h2 class="mb-0"><i data-lucide="map-pin"></i> Ubicación</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="text-white">Nombre del Gimnasio</p>
                                <p class="text-secondary small text-capitalize">
                                    {{ $configuracion->Nombre_Gym ?? 'Sin nombre configurado' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-white">Ubicación</p>
                                <p class="text-secondary small text-capitalize">
                                    {{ $configuracion->Ubicacion ?? 'Sin dirección configurada' }}
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="card card-body mt-4">
                        <h2 class="section-title"><i data-lucide="clock"></i> Horarios de Funcionamiento</h2>
                        <p class="text-gray">
                            Atención: los horarios pueden verse afectados por feriados y días festivos.
                            Consulte con el equipo.
                        </p>

                        @if ($configuracion)
                            @forelse ($configuracion->horarios as $horario)
                                @if ($horario->Habilitacion)
                                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width:100px;">{{ $horario->Dia_Semana }}</div>
                                            <div>Apertura: <span class="text-gray">{{ $horario->Hora_Apertura }}</span></div>
                                            <div>Cierre: <span class="text-gray">{{ $horario->Hora_Cierre }}</span></div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-secondary  text-center">No hay horarios configurados.</p>
                            @endforelse
                        @else
                            <p class="text-secondary text-center">No hay configuración del gimnasio disponible.</p>
                        @endif
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection