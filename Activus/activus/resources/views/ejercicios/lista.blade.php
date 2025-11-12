

<div class="row mt-4" id="contenedor-lista">
    @if($ejercicios->count())
        @foreach($ejercicios as $e)
            <div class="col-sm-12 mb-3">
                <div class="card shadow-sm tarjeta-rutina">
                <div class="card-header d-flex justify-content-between align-items-start mt-3">
                        <div class="flex-grow-1">
                        <h6 class="card-title mb-1">{{ $e->Nombre_Ejercicio}}</h6>
                        <span class="card-text small mb-0">{{ $e->Descripcion}}</span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <p class="mb-1 fw-medium small">
                                    Equipos (<span id="totalEquipos">{{$e->equipos->count()}}</span>):
                                    </p>
                                    @if($e->equipos->count())
                                    @foreach($e->equipos as $equipo)
                                        <span class="badge bg-primary">{{ $equipo->Nombre_Equipo }}</span>
                                    @endforeach
                                    @else
                                        <span class="badge bg-secondary">Sin equipo</span>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="mb-1 fw-medium small">
                                    Músculos (<span id="totalMusculos">{{$e->musculos->count()}}</span>):
                                    </p>
                                    @if($e->musculos->count())
                                    @foreach($e->musculos as $musculo)
                                        <span class="badge bg-primary">{{ $musculo->Nombre_Musculo }}</span>
                                    @endforeach
                                    @else
                                        <span class="badge bg-secondary">Sin músculo</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-secundario" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseEjercicio{{$e->ID_Ejercicio}}"
                            aria-expanded="false"
                            aria-controls="collapseEjercicio{{$e->ID_Ejercicio}}">
                            Ver Instrucciones y Tips
                        </button>

                        <div class="collapse mt-2" id="collapseEjercicio{{$e->ID_Ejercicio}}">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 fw-medium small">Instrucciones:</p>
                                        <div class="small text-secondary">
                                            <span class="ms-1">•</span>
                                            <span>{{ $e->Instrucciones ?: 'Sin instrucciones' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 fw-medium small">Tips:</p>
                                        <div class="small text-secondary">
                                            <span class="ms-1">•</span>
                                            <span>{{ $e->Tips ?: 'Sin tips' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>