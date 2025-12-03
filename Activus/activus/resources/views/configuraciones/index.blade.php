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
                        <h2 class="fw-bold mb-0">Configuración</h2>
                        <span class="text-secondary small">Personaliza la apariencia y funcionamiento de tu gimnasio</span>
                    </div>
                </div>
                <div class="container">
                    <form id="formConfiguracionGym" action="{{ route('configuracion.storeOrUpdate') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf 
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2 class="mb-0">Apariencia</h2>
                            </div>

                            <div class="card-body row g-3"> 
                                <div class="col-md-6">
                                    <label for="NombreGym" class="form-label">Nombre del gimnasio</label>
                                    <input type="text" name="Nombre_Gym" id="NombreGym"
                                        class="form-control card-input @error('Nombre_Gym') is-invalid @enderror"
                                        value="{{ old('Nombre_Gym', $configuracion->Nombre_Gym ?? '') }}">
                                    @error('Nombre_Gym')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="ErrorNombreGym" class="invalid-feedback"></div>
                                </div>

                                 <div class="col-md-6">
                                    <label for="logogym" class="form-label">Logo del gimnasio</label>
                                   <div class="input-group">
                                        <input type="file" name="Logo_PNG" id="logogym" accept="image/*"
                                            class="form-control card-input @error('Logo_PNG') is-invalid @enderror">

                                        @if(!empty($configuracion?->Logo_PNG))
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalLogoActual">
                                                Ver actual
                                            </button>
                                        @endif
                                    </div>

                                    @error('Logo_PNG')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>
                                
                                <div class="col-md-6">
                                     <label for="ColorFondo" class="form-label">Color de fondo</label>
                                    <select name="ID_Color_Fondo" id="colorFondo"
                                        class="form-select card-input @error('ID_Color_Fondo') is-invalid @enderror">
                                        
                                        @foreach ($coloresFondo as $color)
                                            <option  value="{{ $color->ID_Color_Fondo }}" data-hex="{{ $color->Codigo_Hex }}"
                                                {{ (old('ID_Color_Fondo', $configuracion->ID_Color_Fondo ?? 1) == $color->ID_Color_Fondo) ? 'selected' : '' }}>
                                                {{ $color->Nombre_Color }}
                                            </option>

                                        @endforeach
                                    </select>
                                    @error('ID_Color_Fondo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                 
                                <div class="col-md-6">
                                    <label for="colorElemento" class="form-label">Color de los elementos</label>
                                    <input type="color" name="Color_Elemento" id="colorElemento"
                                        class="form-control form-control-color card-input @error('Color_Elemento') is-invalid @enderror"
                                        value="{{ old('Color_Elemento', $configuracion->Color_Elemento ?? '#3198ff') }}">
                                    @error('Color_Elemento') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                    @enderror
                                    <div id="ErrorColorElemento" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>

                        <div class="card card-body mb-4">
                            <h2 class="mb-3">Ubicación</h2>
                            <div class="col-md-8"> <label for="Ubicacion" class="form-label">Dirección</label>
                             <input type="text" name="Ubicacion" id="Ubicacion"
                                    class="form-control card-input @error('Ubicacion') is-invalid @enderror"
                                    value="{{ old('Ubicacion', $configuracion->Ubicacion ?? '') }}">
                                @error('Ubicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="ErrorUbicacionGym" class="invalid-feedback"></div>
                            </div>
                        </div> 

                        <div class="card card-body mb-4">
                          <h2 class="mb-3">Horarios de funcionamiento</h2>
                           <div class="horarios">
                               @foreach($dias as $nombreDia => $info)
                                <div class="horario-item mb-3">
                                <div class="horario-row d-flex align-items-center gap-3 flex-wrap position-relative">
                                    <strong class="nombre-dia me-2">{{ $nombreDia }}</strong>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="habilitado[{{ $nombreDia }}]" {{ $info['habilitado'] ? 'checked' : '' }}>
                                        <label class="form-check-label">Habilitado</label>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <label for="apertura_{{ $nombreDia }}">Apertura:</label>
                                        <input type="time" name="apertura[{{ $nombreDia }}]" id="apertura_{{ $nombreDia }}" class="form-control card-input" value="{{ $info['apertura'] ?? '' }}">
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <label for="cierre_{{ $nombreDia }}">Cierre:</label>
                                        <input type="time" name="cierre[{{ $nombreDia }}]" id="cierre_{{ $nombreDia }}" class="form-control card-input" value="{{ $info['cierre'] ?? '' }}">
                                    </div>

                                    
                                </div>
                                 <div class="text-danger small ms-auto ErrorHorario">
                                </div>
                            </div>

                        @endforeach

                    </div>
                    </div> 
                        <div class="d-flex justify-content-end gap-2"> <a href="{{ url()->previous() }}"
                                class="btn btn-outline-secondary">Cancelar</a> <button type="submit"
                                class="btn btn-agregar">Guardar configuración</button> </div>
                    </form>
                </div>
            </main>
        </div>


<div class="modal fade" id="modalLogoActual" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark p-3">
            <div class="text-center">

                <button type="button" class="btn-close btn-close-white position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                @if(!empty($configuracion?->Logo_PNG))
                <img src="{{ asset('storage/app/public/' . $configuracion->Logo_PNG) }}" 
                alt="Logo actual" 
                class="img-fluid rounded">
                @else
                <p class="text-muted">No hay logo cargado actualmente.</p>
                @endif
            </div>
        </div>
     </div>
</div>
     @include('componentes.modal_exito')
     @vite(['resources/js/configuraciones.js'])
@endsection 