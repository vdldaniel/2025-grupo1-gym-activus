@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        <div class="d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-plus-icon lucide-house-plus"><path d="M12.35 21H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 .71-1.53l7-6a2 2 0 0 1 2.58 0l7 6A2 2 0 0 1 21 10v2.35"/><path d="M14.8 12.4A1 1 0 0 0 14 12h-4a1 1 0 0 0-1 1v8"/><path d="M15 18h6"/><path d="M18 15v6"/></svg>
            <div>
                <h2 class="fw-bold mb-0">Salas</h2>
                <span class="text-secondary small">Administra las salas</span>
            </div>
        </div>
        <div>
            <div class="clases_container" >
            <div class="clases_card">
                <h4>Sala N:</h4>
                <span>Nombre de la sala:</span>
            </div>
            <div class="clases_card">
                <h4>Sala N:</h4>
                <span>Nombre de la sala:</span>
            </div>
            <div class="clases_card">
                <h4>Sala N:</h4>
                <span>Nombre de la sala:</span>
            </div>
            <div class="clases_card">
                <h4>Sala N:</h4>
                <span>Nombre de la sala:</span>
            </div>
            <div class="clases_card">
                <h4>Sala N:</h4>
                <span>Nombre de la sala:</span>
            </div>
            <div class="clases_card">
                <h4>Sala N:</h4>
                <span>Nombre de la sala:</span>
            </div>
        </div>

        </div>
    </div>
</div>
@endsection