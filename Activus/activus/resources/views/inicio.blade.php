@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
        <div class="d-flex align-items-center gap-3">
            <div>
                <h2 class="fw-bold mb-0">Bienvenido/a</h2>
                <p class="text-secondary">Accede para gestionar tu cuenta o visualizar tu perfil.</p>
            </div>
        </div>
    </div>

    @guest
    <!-- Usuario no autenticado -->
    <div class="text-center mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="card-title mb-3">¿Ya tenés una cuenta?</h4>
                <p class="text-secondary mb-4">Iniciá sesión para acceder al panel del gimnasio.</p>
                <a href="{{ route('login.form') }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                </a>
                
            </div>
        </div>
    </div>
    @else
    <!-- Usuario autenticado -->
    <div class="alert alert-success text-center mt-4" role="alert">
        ¡Hola <strong>{{ Auth::user()->Nombre ?? 'Usuario' }}</strong>! Ya estás logueado.  
       
    </div>
    @endguest

</div>
@endsection
