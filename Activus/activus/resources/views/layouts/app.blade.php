@php
  use App\Helpers\PermisoHelper;
  $usuarioAuth = Auth::user();
  $idUsuario = Auth::user()->ID_Usuario ?? null;
@endphp
@php
  $config = configuracion_activa();
  $logo = $config?->Logo_PNG ? asset('storage/app/public/' . $config->Logo_PNG) : null;

  $fondo = $config->colorFondo->Codigo_Hex ?? '#020817';
  $elemento = $config->Color_Elemento ?? '#3198ff';
  $esOscuro = es_color_oscuro($fondo);
@endphp

<style>
  :root {
    /* Variables base segun la configuración */
    --base-clr:
      {{ $fondo }}
    ;
    --primary-element:
      {{ $elemento }}
    ;
    --accent-clr:
      {{ $elemento }}
    ;

    /* segun fondo  */
    --text-clr:
      {{ $esOscuro ? '#e6e6ef' : '#111827' }}
    ;
    --secondary-text-clr:
      {{ $esOscuro ? '#b0b3c1' : '#4b5563' }}
    ;

    --line-clr:
      {{ $esOscuro ? '#42434a' : '#d1d5db' }}
    ;
    --componente-base-clr:
      {{ $esOscuro ? '#0b1322' : '#ffffff' }}
    ;
    --componente-border-clr:
      {{ $esOscuro ? '#1f2937' : '#e5e7eb' }}
    ;
    --secondary-componente-base-clr:
      {{ $esOscuro ? '#111827' : '#f9fafb' }}
    ;
    --secondary-componente-border-clr:
      {{ $esOscuro ? '#1f2730' : '#d1d5db' }}
    ;
    --secondary-line-clr:
      {{ $esOscuro ? '#858585' : '#9ca3af' }}
    ;
    --hover-clr:
      {{ $esOscuro ? '#222533' : '#f3f4f6' }}
    ;

  }
</style>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ $logo }}">

  <title>Activus</title>
  {{-- jQuery --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
    integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
    crossorigin="anonymous"></script>

  {{-- calendario --}}
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
  <!-- Select2 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  {{-- DataTable --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



  {{-- Resources --}}
{{--   @vite(['resources/css/globals.css', 'resources/css/sidebar-menu.css', 'resources/js/sidebar-menu.js', 'resources/css/configuraciones.css', 'resources/js/usuario.js', 'resources/js/validarPerfil.js', 'resources/js/asistencia.js', 'resources/js/profesores-socio.js', 'resources/js/profesores-administrativo.js', 'resources/js/membresias-socio.js', 'resources/js/membresias-administrativo.js', 'resources/js/ejercicio.js', 'resources/js/rutina.js'])
 --}}
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/globals.css', 'resources/css/sidebar-menu.css', 'resources/js/sidebar-menu.js', 'resources/css/configuraciones.css', 'resources/js/validarPerfil.js' ])

</head>

<body>
  @if (!request()->routeIs('ingreso.gimnasio'))
    @auth
      <header>
        <div class="sidenav">
          <div class="menu-container">
            <div class="menu" id="menu">
              <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-menu-icon lucide-menu">
                <path d="M4 5h16" />
                <path d="M4 12h16" />
                <path d="M4 19h16" />
              </svg>
            </div>
          </div>
          <div class="logo-container">

            <div class="logo d-flex align-items-center gap-2" style="padding: 10px 0;">
              
              @if ($logo)
                <img src="{{ $logo }}" alt="Logo del gimnasio" class="logo-gym py-2">
              @else
                <div class="bg-base border-base rounded-circle d-flex justify-content-center align-items-center"
                    style="width:40px; height:40px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                </div>
              @endif

              <span>{{ $config->Nombre_Gym ?? 'Gym' }}</span>
            </div>
          </div>
        </div>
        <div class="topnav">
          @if(PermisoHelper::tienePermiso('Ver Perfil', $idUsuario))
            <a href="/usuarios/{{ $idUsuario }}/perfil" class="text-decoration-none text-reset">
              <div class="bg-base border-base rounded-circle d-flex justify-content-center align-items-center"
                      style="width:40px; height:40px;">
                      <div class="position-relative d-inline-block">
                          @if($usuarioAuth->Foto_Perfil)
                              <img src="{{ asset('storage/app/public/' . $usuarioAuth->Foto_Perfil) }}" alt="Foto de perfil"
                                  class="rounded-circle object-fit-cover" style="width:40px; height:40px;">
                          @else
                              <div class="bg-base border-base rounded-circle d-flex justify-content-center align-items-center"
                                  style="width:40px; height:40px;">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                      fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                                      <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                      <circle cx="12" cy="7" r="4" />
                                  </svg>
                              </div>
                          @endif
                </div>
              </a>
          @endif
        </div>
      </header>

      <div class="sidebar menu-toggle" id="sidebar">
        <nav>
          <ul>
            <li>

              <!--<span class="logo">Gym</span>---->

            </li>
            @if(PermisoHelper::tienePermiso('Ingresar Inicio', $idUsuario))
              <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="/">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-house-icon lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                    <path
                      d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                  </svg>
                  <span class="sidebar-span">Inicio</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Gestionar Socios', $idUsuario))
              <li class="{{ request()->is('socios*') ? 'active' : '' }}">
                <a href="/socios">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <circle cx="9" cy="7" r="4" />
                  </svg>
                  <span class="sidebar-span">Socios</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Gestionar Usuarios', $idUsuario))
              <li class="{{ request()->is('usuarios*') ? 'active' : '' }}">
                <a href="/usuarios">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <circle cx="9" cy="7" r="4" />
                  </svg>
                  <span class="sidebar-span">Usuarios internos</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Clases', $idUsuario))
              <li class="{{ request()->is('clases*') ? 'active' : '' }}">
                <a href="/clases">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-icon lucide-calendar">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                  </svg>
                  <span class="sidebar-span">Clases</span>
                </a>
              </li>
            @endif
            {{-- CLASES – SOCIO --}}
            @if(PermisoHelper::tienePermiso('Clases Socio', $idUsuario))
              <li class="{{ request()->is('clases-socio*') ? 'active' : '' }}">
                <a href="/clases-socio">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-icon lucide-calendar">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                  </svg>
                  <span class="sidebar-span">Mis Clases</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Gestionar Clases', $idUsuario))

              <li class="{{ request()->is('clases/gestion*') ? 'active' : '' }}">
                <a href="/clases/gestion">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-icon lucide-calendar">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                  </svg>
                  <span class="sidebar-span">Clases</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Impartir Clases', $idUsuario))
              <li class="{{ request()->is('clases/mis-clases*') ? 'active' : '' }}">
                <a href="/clases/mis-clases">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-icon lucide-calendar">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                  </svg>
                  <span class="sidebar-span">Clases</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Gestionar Salas', $idUsuario))
              <li class="{{ request()->is('salas*') ? 'active' : '' }}">
                <a href="/salas">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-house-plus-icon lucide-house-plus">
                    <path d="M12.35 21H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 .71-1.53l7-6a2 2 0 0 1 2.58 0l7 6A2 2 0 0 1 21 10v2.35" />
                    <path d="M14.8 12.4A1 1 0 0 0 14 12h-4a1 1 0 0 0-1 1v8" />
                    <path d="M15 18h6" />
                    <path d="M18 15v6" />
                  </svg>
                  <span class="sidebar-span">Salas</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Rutinas', $idUsuario))
              <li class="{{ request()->is('rutinas*') ? 'active' : '' }}">
                <a href="/rutinas">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-dumbbell-icon lucide-dumbbell">
                    <path
                      d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z" />
                    <path d="m2.5 21.5 1.4-1.4" />
                    <path d="m20.1 3.9 1.4-1.4" />
                    <path
                      d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z" />
                    <path d="m9.6 14.4 4.8-4.8" />
                  </svg>
                  <span class="sidebar-span">Rutinas</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Ejercicios', $idUsuario))
              <li class="{{ request()->is('ejercicios*') ? 'active' : '' }}">
                <a href="/ejercicios">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-zap-icon lucide-zap">
                    <path
                      d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z" />
                  </svg>
                  <span class="sidebar-span">Ejercicios</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Profesores', $idUsuario))
              <li class="{{ request()->is('profesores*') ? 'active' : '' }}">
                <a href="/profesores">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <circle cx="9" cy="7" r="4" />
                  </svg>
                  <span class="sidebar-span">Profesores</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Gestion Profesores', $idUsuario))
              <li class="{{ request()->is('profesores/gestion*') ? 'active' : '' }}">
                <a href="/profesores/gestion">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <circle cx="9" cy="7" r="4" />
                  </svg>
                  <span class="sidebar-span">Profesores</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Membresias', $idUsuario))
              <li class="{{ request()->is('membresias*') ? 'active' : '' }}">
                <a href="/membresias">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-crown-icon lucide-crown">
                    <path
                      d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                    <path d="M5 21h14" />
                  </svg>
                  <span class="sidebar-span">Membresías</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Gestionar Membresias', $idUsuario))
              <li class="{{ request()->is('membresias/gestion*') ? 'active' : '' }}">
                <a href="/membresias/gestion">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-crown-icon lucide-crown">
                    <path
                      d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                    <path d="M5 21h14" />
                  </svg>
                  <span class="sidebar-span">Membresías</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Asistencias', $idUsuario))
              <li class="{{ request()->is('asistencias*') ? 'active' : '' }}">
                <a href="/asistencias">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-check-icon lucide-calendar-check">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                    <path d="m9 16 2 2 4-4" />
                  </svg>
                  <span class="sidebar-span">Asistencias</span>
                </a>
              </li>
            @endif
            {{-- PAGOS – ADMINISTRATIVO / ADMIN --}}
            @if(PermisoHelper::tienePermiso('Pagos', $idUsuario))
              <li class="{{ request()->is('pagos*') ? 'active' : '' }}">
                <a href="/pagos">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-credit-card-icon lucide-credit-card">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <line x1="2" x2="22" y1="10" y2="10" />
                  </svg>
                  <span class="sidebar-span">Pagos</span>
                </a>
              </li>
            @endif

            {{-- PAGOS – SOCIO --}}
            @if(PermisoHelper::tienePermiso('Pagos Socio', $idUsuario))
              <li class="{{ request()->is('pagos-socio*') ? 'active' : '' }}">
                <a href="/pagos-socio">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-credit-card-icon lucide-credit-card">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <line x1="2" x2="22" y1="10" y2="10" />
                  </svg>
                  <span class="sidebar-span">Pagos</span>
                </a>
              </li>
            @endif


            @if(PermisoHelper::tienePermiso('Donde Entrenar', $idUsuario))
              <li class="{{ request()->is('donde-entrenar*') ? 'active' : '' }}">
                <a href="/donde-entrenar">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-map-pin-icon lucide-map-pin">
                    <path
                      d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                    <circle cx="12" cy="10" r="3" />
                  </svg>
                  <span class="sidebar-span">Dónde Entrenar</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Configuracion', $idUsuario))
              <li class="{{ request()->is('configuraciones*') ? 'active' : '' }}">
                <a href="/configuraciones">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-settings-icon lucide-settings">
                    <path
                      d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                    <circle cx="12" cy="12" r="3" />
                  </svg>
                  <span class="sidebar-span">Configuración</span>
                </a>
              </li>
            @endif
            @if(PermisoHelper::tienePermiso('Ver Perfil', $idUsuario))
              <li class="{{ request()->is('usuarios/' . $idUsuario . '/perfil') ? 'active' : '' }}">
                <a href="/usuarios/{{ $idUsuario }}/perfil">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-user-icon lucide-user">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                  </svg>
                  <span class="sidebar-span">Perfil</span>
                </a>
              </li>
            @endif
          </ul>
        </nav>
        <div class="sidebar-footer d-flex align-items-center gap-2 px-3 py-2 justify-content-end " id="footer-sidebar">
          <span class="text-secondary small">{{ $usuarioAuth->Nombre }}</span>
          @php
            $rol = $usuarioAuth->roles->first()->Nombre_Rol ?? null;
          @endphp

          @if($rol)
            <span class="badge bg-base bg-opacity-25 border">
              {{ $rol }}
            </span>
          @endif
        </div>
      </div>

    @endauth
  @endif
  </div>




  <main id="main">
    @yield('content')
    
  </main>

  @yield('modales')
</body>

</html>