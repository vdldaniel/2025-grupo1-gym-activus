window.onload = function () {
    cargarMetricas()
    MostrarCalendario();
    inicializarCambioDeVista();

    /// manejo de formulario , eliminacion , edicion de clases (base)
    const btnNuevaClase = document.getElementById("btnNuevaClase");
    const formClase = document.getElementById("formClase");
    const botonConfirmarEliminacion = document.getElementById("btnConfirmarEliminar");

    btnNuevaClase.addEventListener("click", function () {
        LimpiarErrores();
        LimpiarForm();

        formClase.dataset.mode = "create";
        document.querySelector(".modal-title").innerText = "Nueva Clase";
        document.getElementById("btnCrearClase").innerText = "Crear Clase";
        CargarProfesores();
        MostrarModalClase();

    });

    formClase.addEventListener("submit", function (evento) {
        ValidarCreacionClase(evento);
    });


    document.addEventListener("click", async function (event) {
        const botonEdit = event.target.closest(".btnEditarClase");
        LimpiarErrores();
        if (botonEdit) {
            const id = botonEdit.getAttribute("data-id");

            const formClase = document.getElementById("formClase");
            const modalElement = document.getElementById("modalClase");

            // Configurar modo edición
            formClase.dataset.mode = "edit";
            formClase.dataset.id = id;

            await CargarClasePorId(id);

            // Actualizar título y texto del botón SOLO dentro del modal actual
            modalElement.querySelector(".modal-title").innerText = "Editar Clase";
            modalElement.querySelector("#btnCrearClase").innerText = "Guardar Cambios";

            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
        }
    });


    /// clases programadas 

    const btnProgramarClase = document.getElementById("btnProgramarClase");
    const formProgramarClase = document.getElementById("formProgramarClase");


    btnProgramarClase.addEventListener("click", function () {
        LimpiarErroresProg();
        LimpiarFormProg();

        formProgramarClase.dataset.mode = "create";
        document.querySelector(".modal-title").innerText = "Programar Sesión de Clase";
        document.getElementById("btnCrearClaseProgramada").innerText = "Programar Clase";
        // se cargan las opciones de los select del form 
        CargarClases();
        CargarSalas();
        MostrarModalClaseProgramada();

    });

    formProgramarClase.addEventListener("submit", function (evento) {
        ValidarCreacionClaseProgramada(evento);
    });

    document.addEventListener("click", async function (event) {
        const botonEdit = event.target.closest(".btnEditarClaseProgramada");
        LimpiarErroresProg();
        if (botonEdit) {
            const id = botonEdit.getAttribute("data-id");

            const formProgramarClase = document.getElementById("formProgramarClase");
            const modalElement = document.getElementById("modalClaseProgramada");

            //  modo edicion
            formProgramarClase.dataset.mode = "edit";
            formProgramarClase.dataset.id = id;

            await CargarClaseProgPorId(id);


            modalElement.querySelector(".modal-title").innerText = "Editar Sesión de Clase";
            modalElement.querySelector("#btnCrearClaseProgramada").innerText = "Guardar Cambios";

            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
        }
    });

    ///eliminar  clase programada y eliminar clase usan el mismo modal de confirmacion 
    document.addEventListener("click", function (event) {
        const botonElimProg = event.target.closest(".btnEliminarClaseProgramada");
        const botonElimClase = event.target.closest(".btnEliminarClase");
        const modalEliminacion = document.getElementById("modalConfirmarEliminar");

        if (botonElimProg) {
            modalEliminacion.dataset.idClaseProg = botonElimProg.getAttribute("data-id");
            delete modalEliminacion.dataset.idClase;
        }

        if (botonElimClase) {
            modalEliminacion.dataset.idClase = botonElimClase.getAttribute("data-id");
            delete modalEliminacion.dataset.idClaseProg;
        }
    });

    botonConfirmarEliminacion.addEventListener("click", function () {
        const modalEliminacion = document.getElementById("modalConfirmarEliminar");

        if (modalEliminacion.dataset.idClaseProg) {
            EliminacionClaseProgramada(modalEliminacion.dataset.idClaseProg);
        } else if (modalEliminacion.dataset.idClase) {
            EliminacionClase(modalEliminacion.dataset.idClase);
        }
    });



};


function ValidarCreacionClase(evento) {
    evento.preventDefault();

    let oknombre = ValidarNombre();
    let okprofesor = ValidarProfesor();
    let okcapacidad = Validarcapacidad();


    if (oknombre && okprofesor && okcapacidad) {
        GuardarClase();
    }
}

function ValidarCreacionClaseProgramada(evento) {

    evento.preventDefault();
    let okclase = ValidarClase();
    let okfecha = ValidarFecha();
    let okhorainicio = ValidarHoraInicio();
    let okhorafin = ValidarHoraFin();
    let oksala = ValidarSala();
    if (okclase && okfecha && okhorainicio && okhorafin && oksala) {
        GuardarClaseProgramada();
    }


}



////cargar formularios para editar
async function CargarClasePorId(id) {
    try {
        let res = await fetch(`/clases/obtener/${id}`);
        let json = await res.json();


        if (!json.ok) {
            console.error("Error:", json.mensaje || 'No se pudo obtener la clase');
            MostrarError(json.mensaje || "No se pudo cargar la clase para editar.");
            return;
        }


        let data = json.clase;

        document.getElementById("NombreClase").value = data.Nombre_Clase ?? '';
        document.getElementById("Capacidad").value = data.Capacidad_Maxima ?? '';
        // para que se muestre el profesor selecionadoe n el select este activo o no 
        await CargarProfesores(data.ID_Profesor, data.Nombre_Profesor);
        document.getElementById("Profesor").value = data.ID_Profesor ?? '';
    } catch (err) {
        console.error("Error cargando clase:", err);
        MostrarError("Error inesperado al cargar la clase.");
    }

}



async function CargarClaseProgPorId(id) {
    try {
        let res = await fetch(`/clases-programadas/obtener/${id}`);
        let json = await res.json();


        if (!json.ok) {
            console.error("Error:", json.mensaje || 'No se pudo obtener la clase');
            MostrarError(json.mensaje || "No se pudo cargar la clase para editar.");
            return;
        }

        const data = json.claseProgramada;

        // se carga salas y clases en los select mostrando seleccionado el actual 
        await CargarClases(data.ID_Clase);

        document.getElementById("SelectClase").value = data.ID_Clase;
        document.getElementById("FechaClase").value = data.Fecha;
        document.getElementById("HoraInicio").value = data.Hora_Inicio;
        document.getElementById("HoraFin").value = data.Hora_Fin;
        await CargarSalas(data.ID_Sala);
        document.getElementById("SelectSala").value = data.ID_Sala;

    } catch (err) {
        console.error("Error cargando clase:", err);
        MostrarError("Error inesperado al cargar la clase.");
    }

}






/////eliminar

async function EliminacionClase(id) {
    const modal = document.getElementById("modalConfirmarEliminar");
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modal);

    try {
        let response = await fetch(`/clases/eliminar/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        let json = await response.json();


        if (response.ok && json.ok) {
            modalBootstrap.hide();
            cargarClases(); // recargar tabla 
            MostrarExito("¡Eliminada!", json.mensaje || "Clase eliminada.");
            return;
        }

        modalBootstrap.hide();
        MostrarError(json.mensaje || "No se pudo eliminar la clase.");
    } catch (err) {
        console.error("Error eliminando clase:", err);
        MostrarError("Error inesperado al eliminar la clase.");
    }
}


async function EliminacionClaseProgramada(id) {
    const modal = document.getElementById("modalConfirmarEliminar");
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modal);

    try {
        let response = await fetch(`/clases-programadas/eliminar/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        let json = await response.json();


        if (response.ok && json.ok) {
            modalBootstrap.hide();
            cargarClasesProgramadas(); // recargar tabla 
            MostrarExito("¡Eliminada!", json.mensaje);
            return;
        }

        modalBootstrap.hide();
        MostrarError(json.mensaje);
    } catch (err) {
        console.error("Error eliminando clase:", err);
        MostrarError("Error inesperado al eliminar.");
    }
}



//// Guardar   insert y update 

async function GuardarClase() {
    LimpiarErrores();

    const formClase = document.getElementById("formClase");

    let datos = {
        NombreClase: document.querySelector('[name="NombreClase"]').value,
        Profesor: document.querySelector('[name="Profesor"]').value,
        Capacidad: document.querySelector('[name="Capacidad"]').value,
    };

    const isEdit = formClase.dataset.mode === "edit";
    const url = isEdit
        ? `/clases/actualizar/${formClase.dataset.id}`
        : "/clases/guardar";
    const method = isEdit ? "PUT" : "POST";

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(datos)
        });

        const json = await response.json();


        if (response.status === 422) {
            Object.entries(json.errors || {}).forEach(([campo, mensajes]) => {
                let inputId;
                if (campo === "NombreClase") inputId = "NombreClase";
                else if (campo === "Profesor") inputId = "Profesor";
                else if (campo === "Capacidad") inputId = "Capacidad";

                const input = document.getElementById(inputId);

                const errorDivName = {
                    NombreClase: "ErrorNombreClase",
                    Profesor: "ErrorProfesorClase",
                    Capacidad: "ErrorCapacidadClase"
                }[inputId];

                const errorDiv = document.getElementById(errorDivName);

                if (input) input.classList.add("is-invalid");
                if (errorDiv) errorDiv.innerHTML = mensajes.join(", ");
            });
            return;
        }

        if (json.status === "success") {
            CerrarModalClase();
            await cargarClases(); // recargo tabla
            MostrarExito("¡Operación exitosa!", json.message);
            return;
        }


        MostrarError(json.message || "Ocurrió un error al guardar la clase.");

    } catch (err) {
        console.error("Error guardando clase:", err);
        MostrarError("Error inesperado. Verifica la conexión o intenta más tarde.");
    }
}

async function GuardarClaseProgramada() {
    LimpiarErroresProg();

    const formClaseProg = document.getElementById("formProgramarClase");

    let datos = {
        ID_Clase: document.querySelector('[name="SelectClase"]').value,
        ID_Sala: document.querySelector('[name="SelectSala"]').value,
        Fecha: document.querySelector('[name="FechaClase"]').value,
        Hora_Inicio: document.querySelector('[name="HoraInicio"]').value,
        Hora_Fin: document.querySelector('[name="HoraFin"]').value,
    };

    const isEdit = formClaseProg.dataset.mode === "edit";
    const url = isEdit
        ? `/clases-programadas/actualizar/${formClaseProg.dataset.id}`
        : "/clases-programadas/guardar";
    const method = isEdit ? "PUT" : "POST";

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(datos)
        });

        const json = await response.json();


        if (response.status === 422) {
            Object.entries(json.errors || {}).forEach(([campo, mensajes]) => {
                let inputId;

                if (campo === "ID_Clase") inputId = "SelectClase";
                else if (campo === "ID_Sala") inputId = "SelectSala";
                else if (campo === "Fecha") inputId = "FechaClase";
                else if (campo === "Hora_Inicio") inputId = "HoraInicio";
                else if (campo === "Hora_Fin") inputId = "HoraFin";

                const input = document.getElementById(inputId);

                const errorDivName = {
                    SelectClase: "ErrorSelectClase",
                    SelectSala: "ErrorSelectSala",
                    FechaClase: "ErrorFechaClase",
                    HoraInicio: "ErrorHoraInicio",
                    HoraFin: "ErrorHoraFin"
                }[inputId];

                const errorDiv = document.getElementById(errorDivName);

                if (input) input.classList.add("is-invalid");
                if (errorDiv) errorDiv.innerHTML = mensajes.join(", ");
            });
            return;
        }


        if (json.status === "success") {
            CerrarModalClaseProgramada();
            await cargarClasesProgramadas();
            MostrarExito("¡Operación exitosa!", json.message);
            return;
        }


        MostrarError(json.message || "Ocurrió un error al guardar la clase programada.");

    } catch (err) {
        console.error("Error guardando clase programada:", err);
        MostrarError("Error inesperado. Verifica la conexión o intenta más tarde.");
    }
}


// maneja el cambio de las secciones con los botones  

function inicializarCambioDeVista() {
    const btnHorario = document.getElementById('btnHorario');
    const btnProgramadas = document.getElementById('btnProgramadas');
    const btnClases = document.getElementById('btnClases');

    const seccionHorario = document.getElementById('seccionHorario');
    const seccionProgramadas = document.getElementById('seccionProgramadas');
    const seccionClases = document.getElementById('seccionClases');

    const cambiarVista = (vista) => {
        const botones = [btnHorario, btnProgramadas, btnClases];
        const secciones = [seccionHorario, seccionProgramadas, seccionClases];

        // Oculta todas las secciones
        secciones.forEach(s => s.classList.add('d-none'));
        // quita el estado activo de todos los botones
        botones.forEach(b => b.classList.remove('active'));

        switch (vista) {
            case 'horario':
                seccionHorario.classList.remove('d-none');
                btnHorario.classList.add('active');
                MostrarCalendario()

                break;
            case 'programadas':
                seccionProgramadas.classList.remove('d-none');
                btnProgramadas.classList.add('active');
                cargarClasesProgramadas();
                break;
            case 'clases':
                seccionClases.classList.remove('d-none');
                btnClases.classList.add('active');
                cargarClases()
                break;
        }
    };

    // eventos
    btnHorario.addEventListener('click', () => cambiarVista('horario'));
    btnProgramadas.addEventListener('click', () => cambiarVista('programadas'));
    btnClases.addEventListener('click', () => cambiarVista('clases'));


}

async function MostrarCalendario() {

    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;


    calendarEl.innerHTML = `
        <div class="d-flex flex-column justify-content-center align-items-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
            <p class="mt-3 mb-0">Cargando horario...</p>
        </div>
    `;

    try {
        // Obtener eventos
        const response = await fetch('/obtener/eventos');
        const events = await response.json();


        let slotMin = '07:00:00';
        let slotMax = '21:00:00';
        if (events.length > 0) {
            const horasInicio = events.map(e => new Date(e.start).getHours());
            const horasFin = events.map(e => new Date(e.end).getHours());

            let minHora = Math.max(Math.min(...horasInicio) - 1, 0);
            let maxHora = Math.min(Math.max(...horasFin) + 1, 23);

            slotMin = `${String(minHora).padStart(2, '0')}:00:00`;
            slotMax = `${String(maxHora).padStart(2, '0')}:59:59`;
        }



        calendarEl.innerHTML = "";

        // Crear el calendario nuevamente
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            themeSystem: 'bootstrap5',
            initialView: 'timeGridWeek',
            firstDay: 1,
            allDaySlot: false,
            expandRows: true,
            nowIndicator: true,

            height: 'auto',
            contentHeight: 'auto',

            slotMinTime: slotMin,
            slotMaxTime: slotMax,
            slotDuration: '00:30:00',

            headerToolbar: {
                left: '',
                center: 'title',
                right: 'prev,next'
            },

            titleFormat: {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            dayHeaderFormat: { weekday: 'long' },

            buttonText: {
                today: 'Hoy'
            },

            eventDidMount: function (info) {
                info.el.style.whiteSpace = 'normal';
                info.el.style.overflow = 'visible';
                info.el.style.textOverflow = 'unset';
            },

            events: events,

            windowResize: function () {
                if (window.innerWidth < 768) {
                    calendar.changeView('timeGridDay');
                } else {
                    calendar.changeView('timeGridWeek');
                }

                setTimeout(() => {
                    calendar.updateSize();
                    calendar.render();
                }, 50);
            },
        });

        calendar.render();

    } catch (error) {
        console.error(error);

        calendarEl.innerHTML = `
            <div class="text-center text-danger py-4">
                Error al cargar el calendario.
            </div>
        `;
    }
}

/////Cargar tablas

async function cargarClasesProgramadas() {
    const tbody = document.getElementById('tablaClasesProgramadas');


    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2">Cargando clases programadas...</p>
            </td>
        </tr>
    `;

    try {
        const res = await fetch('/clases-programadas/listar');

        if (!res.ok) {
            throw new Error("Respuesta no válida del servidor");
        }

        const data = await res.json();

        // Limpiar tabla
        tbody.innerHTML = "";

        // Si está vacío mostrar mensaje
        if (!data.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        No hay clases programadas.
                    </td>
                </tr>
            `;
            return;
        }

        // Generar filas
        data.forEach(c => {
            const fila = `
                <tr>
                    <td>${c.nombre_clase}</td>
                    <td>${c.profesor}</td>
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users me-2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        ${c.capacidad}
                    </td>
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-map-pin me-2">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        ${c.sala}
                    </td>
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-calendar me-2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        ${c.fecha} &nbsp;|&nbsp; ${c.hora_inicio} - ${c.hora_fin}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-acciones" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user-pen">
                                    <path d="M11.5 15H7a4 4 0 0 0-4 4v2" />
                                    <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                    <circle cx="10" cy="7" r="4" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-acciones">
                                <li>
                                    <button class="dropdown-item editar-btn dropdown-acciones dropdown-item-acciones btnEditarClaseProgramada"
                                        data-id="${c.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-square-pen me-2">
                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                        </svg>
                                        Editar
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger dropdown-item-acciones btnEliminarClaseProgramada"
                                        data-id="${c.id}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalConfirmarEliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash2 me-2">
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', fila);
        });

    } catch (error) {
        console.error("Error al cargar clases programadas:", error);
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-3">
                    Error al cargar las clases programadas.
                </td>
            </tr>
        `;
    }
}




function cargarClases() {

    const tbody = document.getElementById('tablaClases');
    if (!tbody) return;

    tbody.innerHTML = `
        <tr>
            <td colspan="4" class="text-center py-4">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <p class="mt-3 mb-0">Cargando clases...</p>
                </div>
            </td>
        </tr>
    `;

    fetch('/clases/listar')
        .then(res => res.json())
        .then(data => {

            tbody.innerHTML = '';

            // Si no hay clases
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            No hay clases registradas.
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(c => {
                const fila = `
                <tr>
                    <td>${c.nombre_clase}</td>
                    <td>${c.profesor}</td>
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" 
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                             class="lucide lucide-users me-2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        ${c.capacidad}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-acciones" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                     class="lucide lucide-user-pen">
                                    <path d="M11.5 15H7a4 4 0 0 0-4 4v2" />
                                    <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                    <circle cx="10" cy="7" r="4" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-acciones">
                                <li>
                                    <button class="dropdown-item editar-btn dropdown-acciones dropdown-item-acciones btnEditarClase" data-id="${c.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-square-pen me-2">
                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path
                                                d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                        </svg>
                                        Editar
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger dropdown-item-acciones btnEliminarClase" 
                                            data-id="${c.id}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalConfirmarEliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash2 me-2">
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML('beforeend', fila);
            });

        })
        .catch(err => {
            console.error('Error al cargar clases:', err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger py-4">
                        Error al cargar las clases.
                    </td>
                </tr>
            `;
        });
}




/// carga de opciones de select 

async function CargarProfesores(profesorAsignado = null, nombreProfesorAsignado = null) {
    const selectProfesor = document.getElementById("Profesor");
    if (!selectProfesor) return;

    try {
        const response = await fetch("/profesores/activos");
        const profesores = await response.json();


        selectProfesor.innerHTML = `<option value="">Seleccione..</option>`;


        if (profesorAsignado && nombreProfesorAsignado) {
            const yaExiste = profesores.some(p => p.ID_Usuario === profesorAsignado);

            if (!yaExiste) {
                const optionInactivo = document.createElement("option");
                optionInactivo.value = profesorAsignado;
                optionInactivo.textContent = `${nombreProfesorAsignado} (Inactivo)`;
                optionInactivo.disabled = true;
                selectProfesor.appendChild(optionInactivo);
            }
        }


        profesores.forEach(p => {
            const option = document.createElement("option");
            option.value = p.ID_Usuario;
            option.textContent = `${p.Nombre ?? ''} ${p.Apellido ?? ''}`.trim();
            selectProfesor.appendChild(option);
        });

        // si hay  un profe asignado seleccionar(editar)
        if (profesorAsignado) {
            selectProfesor.value = profesorAsignado;
        }

    } catch (error) {
        console.error("Error cargando profesores:", error);
        selectProfesor.innerHTML = `<option value="">Error al cargar</option>`;
    }
}

async function CargarClases(claseSeleccionada = null) {
    const selectClase = document.getElementById("SelectClase");
    if (!selectClase) return;

    try {
        const response = await fetch("/clases/listar");
        const clases = await response.json();


        selectClase.innerHTML = `<option value="">Seleccione..</option>`;


        clases.forEach(c => {
            const option = document.createElement("option");
            option.value = c.id;
            option.textContent = c.nombre_clase ?? "Sin nombre";
            selectClase.appendChild(option);
        });

        // selecciono  la clase  (editar)
        if (claseSeleccionada) {
            selectClase.value = claseSeleccionada;
        }

    } catch (error) {
        console.error("Error cargando clases:", error);
        selectClase.innerHTML = `<option value="">Error al cargar</option>`;
    }
}


async function CargarSalas(salaSeleccionada = null) {
    const selectSala = document.getElementById("SelectSala");
    if (!selectSala) return;

    try {
        const response = await fetch("/salas/listar");
        const salas = await response.json();


        selectSala.innerHTML = `<option value="">Seleccione..</option>`;

        salas.forEach(s => {
            const option = document.createElement("option");
            option.value = s.ID_Sala;
            option.textContent = s.Nombre_Sala ?? "Sin nombre";
            selectSala.appendChild(option);
        });

        // editar
        if (salaSeleccionada) {
            selectSala.value = salaSeleccionada;
        }

    } catch (error) {
        console.error("Error cargando salas:", error);
        selectSala.innerHTML = `<option value="">Error al cargar</option>`;
    }
}

///
async function cargarMetricas() {
    try {
        const res = await fetch('/clases/metricas');
        const json = await res.json();

        if (json.ok) {
            document.getElementById('metricTotalClases').textContent = json.totalClases;
            document.getElementById('metricClasesHoy').textContent = json.clasesHoy;
        } else {
            console.error("Error al obtener métricas");
        }
    } catch (error) {
        console.error("Error de red:", error);
    }
}
///

function MostrarModalClase() {

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalClase"));
    modal.show();


}
function MostrarModalClaseProgramada() {

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalClaseProgramada"));
    modal.show();

}
function CerrarModalClase() {
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalClase"));
    modal.hide();

}
function CerrarModalClaseProgramada() {
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalClaseProgramada"));
    modal.hide();

}
function LimpiarErrores() {
    var elementos = document.querySelectorAll("#formClase input, #formClase select");
    for (var i = 0; i < elementos.length; i++) {
        elementos[i].classList.remove("is-valid", "is-invalid");
    }

    var errores = document.querySelectorAll("#formClase .invalid-feedback");
    for (var j = 0; j < errores.length; j++) {
        errores[j].innerHTML = "";
    }
}
function LimpiarErroresProg() {
    var elementos = document.querySelectorAll("#formProgramarClase input, #formProgramarClase  select");
    for (var i = 0; i < elementos.length; i++) {
        elementos[i].classList.remove("is-valid", "is-invalid");
    }

    var errores = document.querySelectorAll("#formProgramarClase  .invalid-feedback");
    for (var j = 0; j < errores.length; j++) {
        errores[j].innerHTML = "";
    }
}
function LimpiarForm() {

    document.getElementById("formClase").reset();
    LimpiarErrores();
}


function LimpiarFormProg() {

    document.getElementById("formProgramarClase").reset();
    LimpiarErroresProg();
}
//  Validaciones 

function ValidarNombre() {

    let Nombre = document.getElementById("NombreClase");
    let ErrorNombre = document.getElementById("ErrorNombreClase");
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]{2,}$/;
    if (Nombre.value.trim() === "") {

        Nombre.classList.add("is-invalid");
        Nombre.classList.remove("is-valid");
        ErrorNombre.innerHTML = "Debe ingresar un nombre.";
    } else if (!(regex.test(Nombre.value))) {
        Nombre.classList.add("is-invalid");
        Nombre.classList.remove("is-valid");
        ErrorNombre.innerHTML = "Nombre invalido,debe contener al menos 2 caracteres";

    } else {
        Nombre.classList.remove("is-invalid");
        Nombre.classList.add("is-valid");
        ErrorNombre.innerHTML = "";
        return true;
    }
}
function ValidarProfesor() {
    let select = document.getElementById("Profesor");
    let error = document.getElementById("ErrorProfesorClase");

    if (!select.value.trim()) {
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        error.innerHTML = "Seleccione un profesor.";
        return false;
    }

    select.classList.remove("is-invalid");
    select.classList.add("is-valid");
    error.innerHTML = "";
    return true;
}
function Validarcapacidad() {
    let capacidad = document.getElementById("Capacidad");
    let Error = document.getElementById("ErrorCapacidadClase");

    if (capacidad.value.trim() === "") {

        capacidad.classList.add("is-invalid");
        capacidad.classList.remove("is-valid");
        Error.innerHTML = "Debe ingresar una capacidad maxima.";
    } else if (capacidad.value == 0 || capacidad.value < 0) {
        capacidad.classList.add("is-invalid");
        capacidad.classList.remove("is-valid");
        Error.innerHTML = "Debe ingresar una capacidad para la clase valida.";
    } else {
        capacidad.classList.remove("is-invalid");
        capacidad.classList.add("is-valid");
        Error.innerHTML = "";
        return true;
    }
}

function ValidarClase() {
    let select = document.getElementById("SelectClase");
    let error = document.getElementById("ErrorSelectClase");

    if (!select.value.trim()) {
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        error.innerHTML = "Seleccione una clase.";
        return false;
    }

    select.classList.remove("is-invalid");
    select.classList.add("is-valid");
    error.innerHTML = "";
    return true;

}

function ValidarFecha() {
    let input = document.getElementById("FechaClase");
    let error = document.getElementById("ErrorFechaClase");


    if (input.value.trim() === "") {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        error.innerHTML = "Ingrese una fecha.";
        return false;
    }

    input.classList.remove("is-invalid");
    input.classList.add("is-valid");
    error.innerHTML = "";
    return true;

}
function ValidarHoraInicio() {
    let input = document.getElementById("HoraInicio");
    let error = document.getElementById("ErrorHoraInicio");


    if (input.value.trim() === "") {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        error.innerHTML = "Ingrese una hora de inicio.";
        return false;
    }

    input.classList.remove("is-invalid");
    input.classList.add("is-valid");
    error.innerHTML = "";
    return true;
}


function ValidarHoraFin() {
    let input = document.getElementById("HoraFin");
    let error = document.getElementById("ErrorHoraFin");


    if (input.value.trim() === "") {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        error.innerHTML = "Ingrese una hora de fin .";
        return false;
    }

    input.classList.remove("is-invalid");
    input.classList.add("is-valid");
    error.innerHTML = "";
    return true;
}


function ValidarSala() {
    let select = document.getElementById("SelectSala");
    let error = document.getElementById("ErrorSelectSala");

    if (!select.value.trim()) {
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        error.innerHTML = "Seleccione una sala para la clase.";
        return false;
    }

    select.classList.remove("is-invalid");
    select.classList.add("is-valid");
    error.innerHTML = "";
    return true;

}







function MostrarExito(titulo = "Éxito", mensaje = "La operación se realizó con éxito") {
    const modalExito = document.getElementById("modalExito");

    document.getElementById("titulo-exito").innerText = titulo;

    const texto = modalExito.querySelector(".modal-body p");
    texto.innerText = mensaje;

    const instanciaModal = bootstrap.Modal.getOrCreateInstance(modalExito);
    instanciaModal.show();
}
function MostrarError(mensaje) {
    document.getElementById("mensaje-error").innerText = mensaje;
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalError"));
    modal.show();
}


