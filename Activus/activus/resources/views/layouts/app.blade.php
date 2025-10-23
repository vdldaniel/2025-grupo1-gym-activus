@php
  use App\Helpers\PermisoHelper;
  $idUsuarioPrueba = 5; // Usuario autenticado de prueba - 1-Admin 2-Recepcionista 3-Profesor 4-Socio 5-Superadmin
  $currentPath = request()->path(); // Detecta la ruta actual
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- DataTable --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

  {{-- Resources (orden corregido: tus estilos van al final para que prevalezcan) --}}
  @vite([
    'resources/css/globals.css',
    'resources/css/sidebar-menu.css',
    'resources/css/configuraciones.css',
    'resources/css/estilo.css',  {{-- <-- tu archivo de estilos personalizados --}}
    'resources/js/sidebar-menu.js',
    'resources/js/usuario.js',
    'resources/js/asistencia.js',
    'resources/js/profesores-socio.js',
    'resources/js/profesores-administrativo.js',
    'resources/js/membresias-socio.js'
  ])
</head>

<body>
  <nav id="sidebar">
    <ul>
      <li><span class="logo">Gym</span></li>

      {{-- INICIO --}}
      @if(PermisoHelper::tienePermiso('Ingresar Inicio', $idUsuarioPrueba))
        <li class="{{ $currentPath == '/' ? 'active' : '' }}">
          <a href="/">
            <i class="bi bi-house"></i>
            <span class="sidebar-span">Inicio</span>
          </a>
        </li>
      @endif

      {{-- SOCIOS --}}
      @if(PermisoHelper::tienePermiso('Gestionar Socios', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'socios') ? 'active' : '' }}">
          <a href="/socios">
            <i class="bi bi-people"></i>
            <span class="sidebar-span">Socios</span>
          </a>
        </li>
      @endif

      {{-- USUARIOS --}}
      @if(PermisoHelper::tienePermiso('Gestionar Usuarios', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'usuarios') ? 'active' : '' }}">
          <a href="/usuarios">
            <i class="bi bi-person-badge"></i>
            <span class="sidebar-span">Usuarios internos</span>
          </a>
        </li>
      @endif

      {{-- CLASES --}}
      @if(PermisoHelper::tienePermiso('Clases', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'clases') ? 'active' : '' }}">
          <a href="/clases">
            <i class="bi bi-calendar"></i>
            <span class="sidebar-span">Clases</span>
          </a>
        </li>
      @endif

      {{-- SALAS --}}
      @if(PermisoHelper::tienePermiso('Gestionar Salas', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'salas') ? 'active' : '' }}">
          <a href="/salas">
            <i class="bi bi-house-add"></i>
            <span class="sidebar-span">Salas</span>
          </a>
        </li>
      @endif

      {{-- RUTINAS --}}
      @if(PermisoHelper::tienePermiso('Rutinas', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'rutinas') ? 'active' : '' }}">
          <a href="/rutinas">
            <i class="bi bi-dumbbell"></i>
            <span class="sidebar-span">Rutinas</span>
          </a>
        </li>
      @endif

      {{-- EJERCICIOS --}}
      @if(PermisoHelper::tienePermiso('Ejercicios', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'ejercicios') ? 'active' : '' }}">
          <a href="/ejercicios">
            <i class="bi bi-lightning-charge"></i>
            <span class="sidebar-span">Ejercicios</span>
          </a>
        </li>
      @endif

      {{-- PROFESORES --}}
      @if(PermisoHelper::tienePermiso('Profesores', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'profesores') ? 'active' : '' }}">
          <a href="/profesores">
            <i class="bi bi-people-fill"></i>
            <span class="sidebar-span">Profesores</span>
          </a>
        </li>
      @endif

      {{-- MEMBRESIAS --}}
      @if(PermisoHelper::tienePermiso('Membresias', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'membresias') ? 'active' : '' }}">
          <a href="/membresias">
            <i class="bi bi-crown"></i>
            <span class="sidebar-span">Membresías</span>
          </a>
        </li>
      @endif

      {{-- ASISTENCIAS --}}
      @if(PermisoHelper::tienePermiso('Asistencias', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'asistencias') ? 'active' : '' }}">
          <a href="/asistencias">
            <i class="bi bi-calendar-check"></i>
            <span class="sidebar-span">Asistencias</span>
          </a>
        </li>
      @endif

      {{-- PAGOS --}}
      @if(PermisoHelper::tienePermiso('Pagos', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'pagos') ? 'active' : '' }}">
          <a href="/pagos">
            <i class="bi bi-credit-card"></i>
            <span class="sidebar-span">Pagos</span>
          </a>
        </li>
      @endif

      {{-- DONDE ENTRENAR --}}
      @if(PermisoHelper::tienePermiso('Donde Entrenar', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'donde-entrenar') ? 'active' : '' }}">
          <a href="/donde-entrenar">
            <i class="bi bi-geo-alt"></i>
            <span class="sidebar-span">Dónde Entrenar</span>
          </a>
        </li>
      @endif

      {{-- CONFIGURACIÓN --}}
      @if(PermisoHelper::tienePermiso('Configuracion', $idUsuarioPrueba))
        <li class="{{ str_starts_with($currentPath, 'configuraciones') ? 'active' : '' }}">
          <a href="/configuraciones">
            <i class="bi bi-gear"></i>
            <span class="sidebar-span">Configuración</span>
          </a>
        </li>
      @endif

      {{-- PERFIL --}}
      @if(PermisoHelper::tienePermiso('Ver Perfil', $idUsuarioPrueba))
        <li class="{{ str_contains($currentPath, 'perfil') ? 'active' : '' }}">
          <a href="/usuarios/{{ $idUsuarioPrueba }}/perfil">
            <i class="bi bi-person"></i>
            <span class="sidebar-span">Perfil</span>
          </a>
        </li>
      @endif
    </ul>
  </nav>

  <main>
    @yield('content')
  </main>
</body>
</html>
