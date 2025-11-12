<div class="table-responsive p-3" id="contenedor-tabla">
    <table id="tablaEjercicios" class="table table-striped mt-3 small">
        <thead class="">
        <tr>
            <th>ID</th>
            <th>Ejercicio</th>
            <th>Musculos</th>
            <th>Equipo</th>
            {{--   <th>Tips</th>
            <th>Instrucciones</th> --}}
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if($ejercicios->count())
        @foreach($ejercicios as $e)
        <tr>
            <td>{{ $e->ID_Ejercicio }}</td>
            <td>
                {{ $e->Nombre_Ejercicio }}
                <p class="text-secondary small m-0">{{ $e->Descripcion }}</p>
            </td>
            <td>
                @if($e->musculos->count())
                    @foreach($e->musculos as $musculo)
                        <span class="badge bg-primary">{{ $musculo->Nombre_Musculo }}</span>
                    @endforeach
                @else
                    <span class="badge bg-secondary">Sin músculo</span>
                @endif
            </td>
            <td>
                @if($e->equipos->count())
                    @foreach($e->equipos as $equipo)
                        <span class="badge bg-primary">{{ $equipo->Nombre_Equipo }}</span>
                    @endforeach
                @else
                    <span class="badge bg-secondary">Sin equipo</span>
                @endif
            </td>
            {{--   <td>
                {{ $e->Instrucciones }}
            </td>
            <td>
                {{ $e->Tips }}
            </td> --}}
            <td class="text-end">
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-acciones" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-pen-icon lucide-clipboard-pen"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5"/><path d="M4 13.5V6a2 2 0 0 1 2-2h2"/><path d="M13.378 15.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-acciones">
                        <li>
{{--                             <a class="dropdown-item dropdown-acciones dropdown-item-acciones" href={{ route('ejercicios.ver', $e->ID_Ejercicio) }}>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-up-right-icon lucide-move-up-right"><path d="M13 5H19V11"/><path d="M19 5L5 19"/></svg>
                                Ver
                            </a> --}}
                        </li>
                        <li>
                            <button class="dropdown-item editar-btn dropdown-acciones dropdown-item-acciones" data-bs-toggle="modal"
                                data-bs-target="#modalEditarEjercicio"
                                data-id="{{ $e->ID_Ejercicio }}"
                                data-nombre="{{ $e->Nombre_Ejercicio }}"
                                data-descripcion="{{ $e->Descripcion }}"
                                data-musculo='@json(optional($e->musculos)->pluck("ID_Musculo") ?? [])'
                                data-equipo='@json(optional($e->equipos)->pluck("ID_Equipo") ?? [])'
                                data-instrucciones="{{ $e->Instrucciones }}"
                                data-tips="{{ $e->Tips }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen me-2">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                </svg>
                                Editar
                            </button>
                        </li>
                        <li>
                        <button type="button" class="dropdown-item text-danger dropdown-item-acciones" data-bs-target="#modalEliminarEjercicio" data-bs-toggle="modal" data-id="{{ $e->ID_Ejercicio }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 me-2">
                                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                            Eliminar
                        </button>
                                            
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>   
</div>