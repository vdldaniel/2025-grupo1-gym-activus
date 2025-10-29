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
                     <span class="badge bg-primary bg-opacity-25 text-primary border border-primary">
                         <i data-lucide="crown" class="me-1"></i> Básico
                     </span>
                 </div>
             </div>
             <div class="d-flex flex-column gap-2">
                 <div class="d-flex align-items-center gap-2">
                     <i data-lucide="mail" class="text-muted"></i>
                     <span class="small">{{ $usuario->Email }}</span>
                 </div>
                 <div class="d-flex align-items-center gap-2"><i data-lucide="calendar"
                         class="text-muted"></i> <span class="small">Miembro desde: {{ $socio->usuario->Fecha_Alta }}</span>
                 </div>
             </div>
         </div>
     </div>
     @if (!Str::contains(Route::currentRouteName(), 'editarPerfil'))
     <!-- Configuración de Cuenta -->
     <div class="card bg-card text-light shadow-sm">
         <div class="card-header">
             <h5 class="mb-0">Configuración de Cuenta</h5>
         </div>
         <div class="card-body d-flex flex-column gap-2">
             <button class="btn btn-outline-light btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#modalCambiarCorreo">
                 Cambiar Correo
             </button>
             <button class="btn btn-outline-light btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasenia">
                 Cambiar Contraseña
             </button>
             <button class="btn btn-outline-light btn-sm custom-btn">Subir Certificado</button>
             <button class="btn btn-danger btn-sm">Cerrar sesión</button>
         </div>
     </div>
     @endif
 </div>

 @section('modales')
 <!-- Modal Cambiar Correo -->
 <div class="modal fade" id="modalCambiarCorreo" tabindex="-1" aria-labelledby="modalCambiarCorreoLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content bg-card text-light">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalCambiarCorreoLabel">Cambiar Correo</h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
             </div>
             <div class="modal-body">
                 <form id="formCambiarCorreo" method="POST" action="{{ route('usuarios.cambiarCorreo', $usuario->ID_Usuario) }}">
                     @csrf
                     <div class="mb-3">
                         <label for="nuevoCorreo" class="form-label">Nuevo Correo</label>
                         <input type="email" class="form-control" id="nuevoCorreo" name="nuevoCorreo" required>
                     </div>
                     <div class="text-end">
                         <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Cambiar Contraseña -->
 <div class="modal fade" id="modalCambiarContrasenia" tabindex="-1" aria-labelledby="modalCambiarContraseniaLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content bg-card text-light">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalCambiarContraseniaLabel">Cambiar Contraseña</h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
             </div>

             <div class="modal-body">
                 <form id="formCambiarContrasenia" method="POST" action="{{ route('usuarios.cambiarContrasenia', $usuario->ID_Usuario) }}">
                     @csrf
                     
                     <div class="mb-3">
                         <label for="contraseniaActual" class="form-label">Contraseña Actual</label>
                         <input type="password" class="form-control" id="contraseniaActual" name="contraseniaActual" required>
                     </div>
                     <div class="mb-3">
                         <label for="nuevaContrasenia" class="form-label">Nueva Contraseña</label>
                         <input type="password" class="form-control" id="nuevaContrasenia" name="nuevaContrasenia" required>
                         <div class="form-text text-secondary">
                             Debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un símbolo.
                         </div>
                     </div>
                     <div class="mb-3">
                         <label for="confirmarContrasenia" class="form-label">Confirmar Nueva Contraseña</label>
                         <input type="password" class="form-control" id="confirmarContrasenia" name="confirmarContrasenia" required>
                     </div>

                     <div class="text-end">
                         <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 @endsection