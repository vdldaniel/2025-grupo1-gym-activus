@extends('layouts.app')
@section('content')
<div class="container py-4 vista-rutinas">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <div class="d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap flex-shrink-0"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>            <div>
                <h2 class="fw-bold mb-0">{{ $rutina->Nombre_Rutina }}</h2>
                <span class="text-secondary small">{{ $rutina->Descripcion }}</span>
            </div>
        </div>

    </div>

    <div class="row mb-3 mt-3 small text-center text-md-start ">

        <div class="col-4 d-flex align-items-center justify-content-center  mb-2 mb-md-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon me-2">
                <path d="M12 6v6l4 2"/>
                <circle cx="12" cy="12" r="10"/>
            </svg>
            <span>{{ $rutina->Duracion_Aprox }} min</span>
        </div>

        <div class="col-4 d-flex align-items-center justify-content-center  mb-2 mb-md-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon me-2">
                <circle cx="12" cy="12" r="10"/>
                <circle cx="12" cy="12" r="6"/>
                <circle cx="12" cy="12" r="2"/>
            </svg>
            <span>{{ $rutina->Cant_Dias_Semana }} x/semana</span>
        </div>

        <div class="col-4 d-flex align-items-center justify-content-center ">
            @php
                $nivel = $nivelesDificultad->firstWhere('ID_Nivel_Dificultad', $rutina->ID_Nivel_Dificultad);
                $color = match($nivel->Nombre_Nivel_Dificultad ?? '') {
                    'Principiante' => 'success',
                    'Normal' => 'primary',
                    'Avanzado' => 'danger',
                    default => 'secondary'
                };
            @endphp
            <span class="badge bg-{{ $color }}">{{ $nivel->Nombre_Nivel_Dificultad ?? 'Desconocido' }}</span>
        </div>
    </div>


        <div id="card-rutinas" class="card p-3">
            <h6 class="mb-3"></h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Ejercicio</th>
                        <th>Rep/Series</th>
                    </tr>
                </thead>
                <tbody>
                    @if($rutina->ejercicios->count())
                    @foreach($rutina->ejercicios as $re)
                    <tr>
                        <td>
                            {{ $re->Nombre_Ejercicio }}
                        </td>
                        <td>
                            {{ $re->pivot->Series }}x{{ $re->pivot->Repeticiones }} 
                        </td>
                        
                    </tr>                    
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>


@endsection
