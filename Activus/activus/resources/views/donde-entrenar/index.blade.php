@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <!-- Contenido principal -->
        <main class="flex-grow-1 p-4">
            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>            
                <div>
                    <h2 class="fw-bold mb-0">Dónde entrenar</h2>
                    <span class="text-secondary small">Ubicaciones y horarios</span>
                </div>
            </div>
            <div class="container">
                <!-- Ubicación -->
                <div class="card card-body">
                    <h2 class="mb-0"><i data-lucide="map-pin"></i> Ubicación</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="text-white">Nombre del Gimnasio</p>
                            <p class="text-secondary small">Gym Fitness Club </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-white">Ubicación</p>
                            <p class="text-secondary small ">Av. Corrientes 1234, Buenos Aires</p>
                        </div>
                    </div>
                </div>

                <!-- Horarios -->
                <div class="card card-body mt-4">
                    <h2 class="section-title"><i data-lucide="clock"></i> Horarios de Funcionamiento</h2>
                    <p class="text-gray">Atención: los horarios pueden verse afectados por feriados y días festivos.
                        Consulte con el equipo.</p>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Lunes</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                            
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Martes</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                            
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Miércoles</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                            
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Jueves</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                           
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Viernes</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                            
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Sábado</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                            
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                    <div class="card mb-2 p-2 bg-card text-light shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:100px;">Domingo</div>
                            <div>Apertura: <span class="text-gray">06:00</span></div>
                           
                            <div>Cierre: <span class="text-gray">22:00</span></div>
                        </div>
                    </div>
                </div>

            </div>
    
        </main>
    </div>
</div>        
@endsection