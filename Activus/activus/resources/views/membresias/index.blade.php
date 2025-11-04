@extends('layouts.app')
@section('content')
    <div id="vista-membresias" class=" container py-4 vista-membresias ">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-crown-icon lucide-crown">
                    <path
                        d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                    <path d="M5 21h14" />
                </svg>
                <div>
                    <h2 class="fw-bold mb-0">Membresias</h2>
                    <span class="text-secondary small">Conocé nuestras opciones de membresía</span>
                </div>
            </div>
        </div>

        <div id="cardMembresias" class="card p-3">
            <h6 class="mb-3">Lista de Membresías</h6>
            <table class="table ">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>

                    </tr>
                </thead>
                <tbody id="tablaMembresias">

                </tbody>
            </table>
        </div>


    </div>
    @vite(['resources\js\membresias-socio.js'])
@endsection