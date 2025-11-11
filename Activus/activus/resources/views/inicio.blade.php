@extends('layouts.app')



@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    @if(Auth::check())
    @php
    $rol = Auth::user()->roles->first()->ID_Rol ?? null;
    @endphp
    @if($rol === 1)
    @include('inicio.administrador')
    @elseif($rol === 2)
    @include('inicio.administrativo')
    @elseif($rol === 3)
    @include('inicio.profesor')
    @elseif($rol === 4)
    @include('inicio.socio')
    @else
    <h2>Bienvenido Usuario👋</h2>
    @endif


    @else

    <div class="card bg-card  shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-header text-center  ">
            <h2 class="fw-bold mb-0">Bienvenido al Gym</h2>
            <p class="text-secondary mb-0">Ingresa tus credenciales para acceder al panel</p>
        </div>

        <div class="card-body">

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- Correo -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@correo.com" required autofocus>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Botón -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary" id="loginButton">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>


@endsection