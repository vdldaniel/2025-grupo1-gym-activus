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
                     <div class="position-relative d-inline-block">
                         @if($usuario->Foto_Perfil)
                         <img src="{{ asset('storage/'.$usuario->Foto_Perfil) }}"
                             alt="Foto de perfil"
                             class="rounded-circle object-fit-cover"
                             style="width:64px; height:64px;">
                         @else
                         <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center"
                             style="width:64px; height:64px;">
                             <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                                 <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                 <circle cx="12" cy="7" r="4" />
                             </svg>
                         </div>
                         @endif

                         <!-- Botón  editar la foto -->
                         <button class="btn btn-sm btn-secondary position-absolute bottom-0 end-0 rounded-circle p-1"
                             data-bs-toggle="modal"
                             data-bs-target="#modalCambiarFoto"
                             title="Editar foto"
                             style="width:24px; height:24px; line-height:0;">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-camera">
                                 <path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z" />
                                 <circle cx="12" cy="13" r="3" />
                             </svg>
                         </button>
                     </div>
                 </div>
                 <div>
                     <p class="mb-0 fw-semibold">{{ $usuario->Nombre }} {{ $usuario->Apellido }}</p>
                     <span class="badge bg-primary bg-opacity-25 text-primary border border-primary">
                         <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-crown-icon lucide-crown">
                             <path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                             <path d="M5 21h14" />
                         </svg>
                         {{ $membresia && $membresia->tipoMembresia? $membresia->tipoMembresia->Nombre_Tipo_Membresia: 'Sin membresía' }}
                     </span>
                 </div>
             </div>
             <div class="d-flex flex-column gap-2">
                 <div class="d-flex align-items-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail">
                         <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                         <rect x="2" y="4" width="20" height="16" rx="2" />
                     </svg>
                     <span class="small">{{ $usuario->Email }}</span>
                 </div>
                 <div class="d-flex align-items-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar">
                         <path d="M8 2v4" />
                         <path d="M16 2v4" />
                         <rect width="18" height="18" x="3" y="4" rx="2" />
                         <path d="M3 10h18" /></svg> <span class="small">Miembro desde: {{ $socio->usuario->Fecha_Alta }}</span>
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
             <button type="button" class="btn 
    @if(!$certificadoEsteAnio) btn-danger btn-sm custom-btn @else btn btn-outline-light btn-sm custom-btn @endif"
                 data-bs-toggle="modal" data-bs-target="#certificadoModal">
                 @if(!$certificadoEsteAnio)
                 ⚠️ Certificado adeudado
                 @else
                 Mis certificados
                 @endif
             </button>


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
                 @if (session('modal') === 'modalCambiarCorreo')
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <strong>Se encontraron algunos errores:</strong>
                     <ul class="mb-0">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
                 @endif

                 @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
                 @endif

                 @if (session('warning'))
                 <div class="alert alert-warning">{{ session('warning') }}</div>
                 @endif

                 @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
                 @endif
                 @endif

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
                 @if (session('modal') === 'modalCambiarContrasenia')
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <strong>Se encontraron algunos errores:</strong>
                     <ul class="mb-0">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
                 @endif

                 @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
                 @endif

                 @if (session('warning'))
                 <div class="alert alert-warning">{{ session('warning') }}</div>
                 @endif

                 @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
                 @endif
                 @endif
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
                         <input type="password" class="form-control" id="confirmarContrasenia" name="repetirContrasenia" required>
                     </div>

                     <div class="text-end">
                         <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Subir Certificado -->
 <div class="modal fade" id="certificadoModal" tabindex="-1" aria-labelledby="certificadoModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content bg-card text-light">
             <div class="modal-header">
                 <h5 class="modal-title" id="certificadoModalLabel">Mis Certificados</h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
             </div>
             <div class="modal-body">
                 @if (session('modal') === 'certificadoModal')
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <strong>Se encontraron algunos errores:</strong>
                     <ul class="mb-0">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
                 @endif

                 @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
                 @endif

                 @if (session('warning'))
                 <div class="alert alert-warning">{{ session('warning') }}</div>
                 @endif

                 @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
                 @endif
                 @endif
                 <!-- Lista de certificados existentes -->
                 @if(!$certificados->isEmpty())

                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>Imagen</th>
                             <th>Aprobado</th>
                             <th>Emisión</th>
                             <th>Vencimiento</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($certificados as $certificado)
                         <tr>
                             <td>
                                 <a href="{{ asset('storage/'.$certificado->Imagen_Certificado) }}" target="_blank" class="text-primary me-2">Ver</a>

                                 <form id="delete-cert-{{ $certificado->id }}"
                                     action="{{ route('usuarios.eliminarCertificado', [$usuario->ID_Usuario, $certificado->ID_Certificado]) }}"
                                     method="POST" style="display:inline;">
                                     @csrf
                                     @method('DELETE')
                                     <a href="#" class="text-danger"
                                         onclick="event.preventDefault(); if(confirm('¿Seguro que deseas eliminar este certificado?')) document.getElementById('delete-cert-{{ $certificado->id }}').submit();">
                                         Eliminar
                                     </a>
                                 </form>
                             </td>
                             <td>
                                 @if($certificado->Aprobado)
                                 <span class="badge bg-success">Aprobado</span>
                                 @else
                                 <span class="badge bg-warning text-dark">Pendiente</span>
                                 @endif
                             </td>
                             <td>{{ $certificado->Fecha_Emision }}</td>
                             <td>{{ $certificado->Fecha_Vencimiento }}</td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
                 @endif

                 <!-- Formulario para subir nuevo certificado -->
                 <hr>
                 @if(!$certificadoEsteAnio)
                 <div class="alert alert-warning">
                     No has subido el certificado correspondiente al año {{ $anioActual }}.
                     Por favor, carga el certificado para mantener tu perfil al día.
                 </div>
                 @endif

                 <form action="{{ route('usuarios.subirCertificado', $usuario->ID_Usuario) }}" method="POST" enctype="multipart/form-data">

                     @csrf
                     <div class="mb-3">

                         <div class="mb-3">
                             <label for="imagen_certificado" class="form-label">Subir nuevo certificado</label>
                             <input type="file" class="form-control" name="certificado" required>

                         </div>
                     </div>
                     <button type="submit" class="btn btn-primary">Subir</button>
                 </form>

             </div>
         </div>
     </div>
 </div>

 <!-- Modal Cambiar Foto -->
 <div class="modal fade" id="modalCambiarFoto" tabindex="-1" aria-labelledby="modalCambiarFotoLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content bg-card text-light">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalCambiarFotoLabel">Cambiar Foto de Perfil</h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
             </div>
             <div class="modal-body">

                 @if (session('modal') === 'modalCambiarFoto')
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <strong>Se encontraron algunos errores:</strong>
                     <ul class="mb-0">
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
                 @endif
                 @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
                 @endif
                 @endif

                 <form method="POST" action="{{ route('usuarios.cambiarFoto', $usuario->ID_Usuario) }}" enctype="multipart/form-data">
                     @csrf

                     <div class="mb-3 text-center">
                         <label for="foto" class="form-label">Seleccionar nueva foto</label>
                         <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>

                         <div id="preview" class="mt-3">
                             @if ($usuario->Foto_Perfil)
                             <img src="{{ asset('storage/'.$usuario->Foto_Perfil) }}"
                                 class="rounded-circle object-fit-cover"
                                 style="width:80px; height:80px;">

                             {{-- Enlace para eliminar --}}
                             <a href="#" class="text-danger d-block mt-2"
                                 onclick="event.preventDefault(); 
                            if(confirm('¿Seguro que deseas eliminar la foto de perfil?')) 
                                document.getElementById('delete-foto-{{ $usuario->ID_Usuario }}').submit();">
                                 Eliminar foto
                             </a>
                             @endif
                         </div>
                     </div>

                     <div class="text-end">
                         <button type="submit" class="btn btn-primary">Guardar Foto</button>
                     </div>
                 </form>
                 {{-- Formulario de eliminación fuera del anterior --}}
                 <form id="delete-foto-{{ $usuario->ID_Usuario }}"
                     action="{{ route('usuarios.eliminarFoto', $usuario->ID_Usuario) }}"
                     method="POST" style="display:none;">
                     @csrf
                     @method('DELETE')
                 </form>
             </div>
         </div>
     </div>
 </div>

 @if (session('modal'))
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const modalId = "{{ session('modal') }}";
         const modalEl = document.getElementById(modalId);
         if (modalEl) {
             const modal = new bootstrap.Modal(modalEl);
             modal.show();
         }
     });
 </script>
 @endif

 <script>
     document.getElementById('foto')?.addEventListener('change', function(e) {
         const [file] = e.target.files;
         if (file) {
             const preview = document.getElementById('preview');
             preview.innerHTML = `<img src="${URL.createObjectURL(file)}" class="rounded-circle" style="width:80px; height:80px; object-fit:cover;">`;
         }
     });
 </script>

 @endsection