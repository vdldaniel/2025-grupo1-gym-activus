@php
    use App\Helpers\PermisoHelper;
    $idUsuarioPrueba = 5; //Usuario autenticado de prueba - 1-Admin 2-Recepcionista 3-Profesor 4-Socio 5-Superadmin
@endphp

<div class="row g-4 mt-2 mb-4" id="contenedorRutinas">
        @if($rutinas->count())
        @foreach($rutinas as $r)
        <div class="col-12 col-lg-6">
            <div class="card h-100 shadow-sm tarjeta-rutina">
                <div class="card-header d-flex justify-content-between align-items-start mt-3">
                    <div class="flex-grow-1 vista-rutinas">
                    <a class="text-decoration-none" href="/rutinas/{{ $r->ID_Rutina}}">
                        <h5 class="card-title mb-1">{{ $r->Nombre_Rutina}}</h5>
                    </a>
                    <span class="card-text small mb-0">{{ $r->Descripcion}}</span>
                    </div>

                    @if(PermisoHelper::tienePermiso('Gestionar Rutinas', $idUsuarioPrueba))
                    <div class="dropdown">
                    <button class="btn btn-sm" type="button" id="menuRutina" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                    </button>
                    <ul class="dropdown-menu dropdown-acciones dropdown-menu-end" aria-labelledby="menuRutina">
                        <li>
                            @php
                                $series = $r->ejercicios->pluck('pivot.Series')->toArray();
                                $repeticiones = $r->ejercicios->pluck('pivot.Repeticiones')->toArray();
                            @endphp
                                <button class="dropdown-item editar-btn dropdown-acciones dropdown-item-acciones" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarRutina"
                                        data-id="{{ $r->ID_Rutina }}"
                                        data-nombre="{{ $r->Nombre_Rutina }}"
                                        data-descripcion="{{ $r->Descripcion }}"
                                        data-dificultad="{{ $r->ID_Nivel_Dificultad }}"
                                        data-duracion="{{ $r->Duracion_Aprox }}"
                                        data-dias="{{ $r->Cant_Dias_Semana }}"
                                        data-ejercicio='@json(optional($r->ejercicios)->pluck("ID_Ejercicio")->toArray() ?? [])'
                                        data-serie='@json($series)'
                                        data-repeticion='@json($repeticiones)'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen me-2">
                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                    </svg>
                                    Editar
                                </button>

                            </li>
                            <li>
                            <button type="button" class="dropdown-item text-danger dropdown-item-acciones" data-bs-target="#modalEliminarRutina" data-bs-toggle="modal" data-id="{{ $r->ID_Rutina }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 me-2">
                                    <path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                                Eliminar
                            </button>
                                                
                            </li>
                    </ul>
                    </div>
                    @endif
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        @php
                            $nivel = $nivelesDificultad->firstWhere('ID_Nivel_Dificultad', $r->ID_Nivel_Dificultad);
                            $color = match($nivel->Nombre_Nivel_Dificultad ?? '') {
                                'Principiante' => 'success',
                                'Normal' => 'primary',
                                'Avanzado' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                    <span class="badge bg-{{ $color }}">{{ $nivel->Nombre_Nivel_Dificultad ?? 'Desconocido' }}</span>
                    </div>

                    <div class="row  mb-3 small">
                    <div class="col d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                        <span class="ms-2" id="minutos">{{ $r->Duracion_Aprox}}</span> 
                        <span class="ms-1">min</span>                   
                    </div>
                    <div class="col d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="ms-2" id="cantidadSemanal">{{ $r->Cant_Dias_Semana }}</span> 
                        <span class="ms-1">x/semana</span>     
                    </div>
                    </div>

                    <div>
                    <p class="mb-1 fw-medium small">
                    Ejercicios (<span class="" id="totalEjercicios">{{ $r->ejercicios->count() }}</span>):
                    </p>

                    @if($r->ejercicios->count())
                        @foreach($r->ejercicios as $e)
                            <div class="small text-secondary">
                                <span class="ms-1">•</span>
                                <span class="mx-2">{{ $e->Nombre_Ejercicio }}</span> 
                                <span>{{ $e->pivot->Series }}</span> 
                                <span>x</span>
                                <span>{{ $e->pivot->Repeticiones }}</span>      
                            </div>
                        @endforeach
                    @endif

                    </div>
                </div>
            </div>
            
        </div>
        @endforeach
        @endif
    </div>