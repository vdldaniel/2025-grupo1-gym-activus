<!-- Columna lateral -->
<div class="col-lg-4 d-flex flex-column gap-3">
    <!-- Resumen del Perfil -->
    <div class="card bg-card text-light shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Resumen del Perfil</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center"
                    style="width:64px; height:64px;">
                    <i data-lucide="user" class="text-light"></i>
                </div>
                <div>
                    <p class="mb-0 fw-semibold">{{ $usuario->Nombre }} {{ $usuario->Apellido }}</p>
                    <small class="mb-1 small">Rol: Recepcionista</small>
                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i data-lucide="mail" class="text-muted"></i>
                    <span class="small">{{ $usuario->Email }}</span>
                </div>
                <div class="d-flex align-items-center gap-2"><i data-lucide="calendar"
                        class="text-muted"></i> <span class="small">Miembro desde: {{ $usuario->Fecha_Alta }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuración de Cuenta -->
    <div class="card bg-card text-light shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Configuración de Cuenta</h5>
        </div>
        <div class="card-body d-flex flex-column gap-2">
            <button class="btn btn-outline-light btn-sm custom-btn">Cambiar Correo</button>
            <button class="btn btn-outline-light btn-sm custom-btn">Cambiar Contraseña</button>
            <button class="btn btn-outline-light btn-sm custom-btn">Configuración</button>
            <button class="btn btn-danger btn-sm">Cerrar sesión</button>
        </div>
    </div>
</div>