document.addEventListener("DOMContentLoaded", () => {

    const btnHorario = document.getElementById("btnHorario");
    const btnInscripcion = document.getElementById("btnInscripcion");

    const seccionHorario = document.getElementById("seccionHorario");
    const seccionInscripcion = document.getElementById("seccionInscripcion");

    const tablaClases = document.getElementById("tablaClasesDisponibles");

    const modal = new bootstrap.Modal(document.getElementById("modalNotificacion"));
    const modalMsg = document.getElementById("modalNotificacionMensaje");
    const modalBtn = document.getElementById("btnModalAccion");

    let claseSeleccionada = null;
    let accion = null; // "inscribir" o "cancelar"

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;


    // ======================================================
    //   CAMBIO DE PESTAÑAS
    // ======================================================
    btnHorario.addEventListener("click", () => {
        btnHorario.classList.add("active");
        btnInscripcion.classList.remove("active");

        seccionHorario.classList.remove("d-none");
        seccionInscripcion.classList.add("d-none");
    });

    btnInscripcion.addEventListener("click", () => {
        btnInscripcion.classList.add("active");
        btnHorario.classList.remove("active");

        seccionInscripcion.classList.remove("d-none");
        seccionHorario.classList.add("d-none");

        cargarClasesDisponibles();
    });


    // ======================================================
    //   CARGAR MÉTRICAS
    // ======================================================
    async function cargarMetricas() {
        const res = await fetch("/clases-socio/metricas");
        const data = await res.json();

        document.getElementById("metricTotalClases").textContent = data.total;
        document.getElementById("metricClasesHoy").textContent = data.hoy;
    }
    cargarMetricas();


    // ======================================================
    //   CALENDARIO (clases del socio)
    // ======================================================
    const calendarEl = document.getElementById("calendar");
    let calendarInstance = null;

    if (calendarEl) {
        calendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: "timeGridWeek",
            locale: "es",
            height: 650,
            events: "/clases-socio/eventos"
        });

        calendarInstance.render();
    }


    // ======================================================
    //   CARGAR CLASES DISPONIBLES
    // ======================================================
    async function cargarClasesDisponibles() {
        tablaClases.innerHTML = `
            <tr><td colspan="6" class="text-center py-3 text-secondary">
                Cargando clases...
            </td></tr>
        `;

        const res = await fetch("/clases-socio/disponibles");
        const clases = await res.json();

        tablaClases.innerHTML = "";

        if (!clases.length) {
            tablaClases.innerHTML = `
                <tr><td colspan="6" class="text-center py-3">
                    No hay clases disponibles en este momento.
                </td></tr>
            `;
            return;
        }

        clases.forEach(c => {
            const fila = document.createElement("tr");

            let boton = "";

            if (c.ID_Reserva === null) {
                boton = `
                    <button class="btn btn-accent btn-sm btnInscribir" data-id="${c.ID_Clase_Programada}">
                        Inscribirse
                    </button>
                `;
            } else {
                boton = `
                    <button class="btn btn-danger btn-sm btnCancelar" data-id="${c.ID_Clase_Programada}">
                        Cancelar
                    </button>
                `;
            }

            fila.innerHTML = `
                <td>${c.Nombre_Clase}</td>
                <td>${c.Profesor}</td>
                <td>${c.Capacidad_Usada}/${c.Capacidad_Maxima}</td>
                <td>${c.Sala}</td>
                <td>${c.Fecha} ${c.Hora_Inicio} - ${c.Hora_Fin}</td>
                <td>${boton}</td>
            `;

            tablaClases.appendChild(fila);
        });

        activarBotones();
    }



    // ======================================================
    //   ACTIVAR BOTONES
    // ======================================================
    function activarBotones() {

        // INSCRIBIR
        document.querySelectorAll(".btnInscribir").forEach(btn => {
            btn.addEventListener("click", () => {
                claseSeleccionada = btn.dataset.id;
                accion = "inscribir";

                modalMsg.textContent = "¿Deseas inscribirte a esta clase?";
                modalBtn.textContent = "Inscribirme";

                modal.show();
            });
        });

        // CANCELAR
        document.querySelectorAll(".btnCancelar").forEach(btn => {
            btn.addEventListener("click", () => {
                claseSeleccionada = btn.dataset.id;
                accion = "cancelar";

                modalMsg.textContent = "¿Seguro que quieres cancelar tu inscripción?";
                modalBtn.textContent = "Cancelar inscripción";

                modal.show();
            });
        });
    }



    // ======================================================
    //   CONFIRMAR ACCIÓN DEL MODAL
    // ======================================================
    modalBtn.addEventListener("click", async () => {

        if (!claseSeleccionada || !accion) return;

        let url = "";
        let metodo = "POST";

        if (accion === "inscribir") {
            url = `/clases-socio/inscribirse/${claseSeleccionada}`;
        } else if (accion === "cancelar") {
            url = `/clases-socio/cancelar/${claseSeleccionada}`;
        }

        const res = await fetch(url, {
            method: metodo,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            }
        });

        const data = await res.json();

        if (!data.success) {

            if (data.motivo === "fuera_de_tiempo") {
                modalMsg.textContent = "Solo puedes cancelar con 24 horas de anticipación.";
                modalBtn.textContent = "Aceptar";
                accion = null;
                return;
            }

            modalMsg.textContent = data.message;
            modalBtn.textContent = "Aceptar";
            accion = null;
            return;
        }

        modal.hide();

        await cargarClasesDisponibles();
        await cargarMetricas();

        if (calendarInstance) {
            calendarInstance.refetchEvents();
        }

        accion = null;
        claseSeleccionada = null;
    });

});
