@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">

        
            <!-- Contenido principal -->
        <main class="flex-grow-1 p-4">
        

            <div class="d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>            
                <div>
                    <h2 class="fw-bold mb-0">Configuración</h2>
                    <span class="text-secondary small">Personaliza la apariencia y funcionamiento de tu gimnasio</span>
                </div>
            </div>
        <div class="container">
            <!-- Apariencia -->
            <div class="card">
            <div class="card-header">
                <i data-lucide="palette"></i>
                <h2>Apariencia</h2>
            </div>
            <div class="card-body d-flex  grid-2 gap-3">
                <div>
                <label for="gymName">Nombre del gimnasio</label>
                <input type="text" class="text-secondary small card mb-2 p-2" id="gymName" placeholder="Gym Fitness Club">
                </div>
                <div>
                    <label for="colorFondo">Color de fondo</label>
                    <select  id="colorFondo">
                        <option>Azul</option>
                        <option>Verde</option>
                        <option>Púrpura</option>
                        <option>Rojo</option>
                        <option>Naranja</option>
                        <option>Rosa</option>
                    </select>
                </div>
                <div>
                    <label for="colorElemento">Color de elemento</label>
                    <select id="colorElemento">
                        <option>Azul</option>
                        <option>Verde</option>
                        <option>Púrpura</option>
                        <option>Rojo</option>
                        <option>Naranja</option>
                        <option>Rosa</option>
                    </select>
                </div>
                
            </div>
            <div class="card-body">
                <label for="logoUpload">Logo del gimnasio</label>
                <input type="file" class="text-secondary small card mb-2 p-2"  id="logoUpload" accept="image/*">
                </div>
            </div>
           

            <!-- Ubicación -->
            
            <div class="card card-body mt-4">
               
                <h2 class="mb-0">Ubicación</h2>
            
                <label for="ubicacion">Dirección</label>
                <input type="text" class="text-secondary small card mb-2 p-2" id="ubicacion" placeholder="Av. Corrientes 1234, Buenos Aires">
            </div>
            

            <!-- Horarios -->
            <div class="card card-body mt-4">
                <i data-lucide="clock"></i>
                <h2 class="mb-0">Horarios de funcionamiento</h2>
        
                <div class="card-body horarios">
                    <div class="horario-row">
                    <span>Lunes</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>

                    <div class="horario-row">
                    <span>Martes</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>

                    <div class="horario-row">
                    <span>Miércoles</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>

                    <div class="horario-row">
                    <span>Jueves</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>

                    <div class="horario-row">
                    <span>Viernes</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>

                    <div class="horario-row">
                    <span>Sábado</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>

                    <div class="horario-row">
                    <span>Domingo</span>
                    <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                    <label>Apertura:</label><input type="time" value="06:00">
                    <label>Cierre:</label><input type="time" value="22:00">
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="card-body d-flex gap-2 mt-4 justify-content-end">
            <button class="btn btn-outline-light btn-sm custom-btn">Cancelar</button>
            <button class="btn btn-agregar py-2 px-4 btn-sm">Guardar configuración</button>
            </div>

        </div>
        </main>
    </div>
</div>
@endsection