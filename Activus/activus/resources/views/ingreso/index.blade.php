@php
    $config = configuracion_activa();
    $nombreGym = $config->Nombre_Gimnasio ?? null;
@endphp
@extends('layouts.app')
@section('content')
    <a href="{{ route('inicio.administrativo') }}" class="volver-btn " style="text-decoration:none;">
        <i class="bi bi-arrow-left me-2"></i> Volver al inicio
    </a>
    <div class="ingreso-container p-3">
        <div class="card card-ingreso p-4 shadow-lg">

            <h3 class="text-center mb-1">
                Bienvenido
                @if ($nombreGym)
                    a {{ $nombreGym }}
                @else
                    al Gym
                @endif
            </h3>
            <p class="text-center  mb-4">Coloca tu DNI para validar tu acceso</p>

            {{-- form --}}
            <form id="formIngreso">
                @csrf
                <label for="dni" class=" mb-1">DNI</label>

                <div class="input-group mb-3">
                    <span class="input-group-text border-secondary icon-input card-input">
                        <i class="bi bi-person-vcard"></i>
                    </span>
                    <input type="number" id="dni" class="form-control card-input border-secondary"
                        placeholder="Ej: 12345678">
                </div>


                <button type="submit" class="btn btn-agregar w-100">
                    Ingresar
                </button>
            </form>

            {{-- mensaje --}}
            <div id="resultado" class="mt-3"></div>
        </div>
    </div>
    @vite(['resources/js/ingresoGym.js'])
@endsection