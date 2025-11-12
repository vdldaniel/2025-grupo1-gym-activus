document.addEventListener("DOMContentLoaded", () => {
  if (!window.location.pathname.includes("/clases-socio")) return;

  inicializarCambioDeVista();
  mostrarCalendario();
  cargarClasesDisponibles();
  actualizarMetricas();
});

// ==============================
// CAMBIO ENTRE VISTAS
// ==============================
function inicializarCambioDeVista() {
  const btnHorario = document.getElementById("btnHorario");
  const btnInscripcion = document.getElementById("btnInscripcion");
  const seccionHorario = document.getElementById("seccionHorario");
  const seccionInscripcion = document.getElementById("seccionInscripcion");

  if (!btnHorario || !btnInscripcion || !seccionHorario || !seccionInscripcion) return;

  const cambiarVista = (vista) => {
    [seccionHorario, seccionInscripcion].forEach((s) => s.classList.add("d-none"));
    [btnHorario, btnInscripcion].forEach((b) => b.classList.remove("active"));

    if (vista === "horario") {
      seccionHorario.classList.remove("d-none");
      btnHorario.classList.add("active");
    } else {
      seccionInscripcion.classList.remove("d-none");
      btnInscripcion.classList.add("active");
    }
  };

  btnHorario.addEventListener("click", () => cambiarVista("horario"));
  btnInscripcion.addEventListener("click", () => cambiarVista("inscripcion"));
}

// ==============================
// CALENDARIO DE CLASES RESERVADAS
// ==============================
function mostrarCalendario() {
  const calendarEl = document.getElementById("calendar");
  if (!calendarEl) return;

  calendarEl.innerHTML = `
    <div class="calendar-loader text-center">
      <div class="spinner-border text-light" role="status"></div>
      <p class="mt-2">Cargando tus clases...</p>
    </div>`;

  fetch("/clases-socio/eventos")
    .then((res) => res.json())
    .then((events) => {
      calendarEl.innerHTML = "";

      // 🔹 Marcar eventos pasados
      events.forEach((e) => {
        if (new Date(e.end) < new Date()) e.className = "past-event";
      });

      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "es",
        themeSystem: "bootstrap5",
        initialView: window.innerWidth < 768 ? "listWeek" : "timeGridWeek",
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "timeGridWeek,listWeek",
        },
        height: "580px", // 🔹 altura controlada
        contentHeight: "580px",
        expandRows: false,
        aspectRatio: 1.6,
        stickyHeaderDates: false,
        nowIndicator: events.some(ev => new Date(ev.start) >= new Date()),
        dayMaxEvents: true,
        slotLabelFormat: { hour: "2-digit", minute: "2-digit", hour12: false },
        titleFormat: { year: "numeric", month: "short", day: "numeric" },
        events,
        eventColor: "#007bff",
        eventDisplay: "block",
        eventTimeFormat: { hour: "2-digit", minute: "2-digit", hour12: false },
        windowResize: () => {
          const newView = window.innerWidth < 768 ? "listWeek" : "timeGridWeek";
          calendar.changeView(newView);
        },
      });

      calendar.render();
    })
    .catch(() => {
      calendarEl.innerHTML = `
        <p class="calendar-error text-danger text-center">
          No se pudieron cargar tus clases.
        </p>`;
    });
}

// ==============================
// TABLA DE CLASES DISPONIBLES
// ==============================
function cargarClasesDisponibles() {
  const tabla = document.getElementById("tablaClasesDisponibles");
  if (!tabla) return;

  tabla.innerHTML = `
    <tr><td colspan="6" class="text-center text-secondary py-3">
      Cargando clases disponibles...
    </td></tr>`;

  fetch("/clases-socio/disponibles")
    .then((res) => res.json())
    .then((data) => {
      if (!data.length) {
        tabla.innerHTML = `
          <tr><td colspan="6" class="text-center text-secondary py-3">
            No hay clases disponibles.
          </td></tr>`;
        return;
      }

      tabla.innerHTML = data
        .map(
          (c) => `
        <tr>
          <td>${c.Nombre_Clase}</td>
          <td>${c.Profesor || "-"}</td>
          <td>${c.Capacidad_Usada}/${c.Capacidad_Maxima}</td>
          <td>${c.Sala || "-"}</td>
          <td>${c.Fecha} ${c.Hora_Inicio} - ${c.Hora_Fin}</td>
          <td>
            <button class="btn btn-sm btn-agregar" onclick="inscribirse(${c.ID_Clase_Programada})">
              Inscribirse
            </button>
          </td>
        </tr>`
        )
        .join("");
    })
    .catch(() => {
      tabla.innerHTML = `
        <tr><td colspan="6" class="text-center text-danger py-3">
          Error al cargar los datos.
        </td></tr>`;
    });
}

// ==============================
// MÉTRICAS
// ==============================
async function actualizarMetricas() {
  try {
    const res = await fetch("/clases-socio/metricas");
    const data = await res.json();

    document.getElementById("metricTotalClases").textContent = data.total || 0;
    document.getElementById("metricClasesHoy").textContent = data.hoy || 0;
  } catch {
    console.warn("No se pudieron actualizar las métricas");
  }
}

// ==============================
// INSCRIPCIÓN
// ==============================
function inscribirse(idClase) {
  const modalEl = document.getElementById("modalNotificacion");
  const tituloEl = document.getElementById("modalNotificacionLabel");
  const cuerpoEl = document.getElementById("modalNotificacionMensaje");
  const btnConfEl = document.getElementById("btnConfirmarInscripcion");

  if (!modalEl || !tituloEl || !cuerpoEl || !btnConfEl) return;

  tituloEl.textContent = "Confirmar inscripción";
  cuerpoEl.textContent = "¿Deseas inscribirte a esta clase?";

  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  modal.show();

  const nuevoBtn = btnConfEl.cloneNode(true);
  btnConfEl.parentNode.replaceChild(nuevoBtn, btnConfEl);

  nuevoBtn.addEventListener(
    "click",
    async () => {
      cuerpoEl.innerHTML = `
        <div class="calendar-loader text-center">
          <div class="spinner-border text-light" role="status"></div>
          <p class="mt-3">Procesando inscripción...</p>
        </div>`;

      try {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        const res = await fetch(`/clases-socio/inscribirse/${idClase}`, {
          method: "POST",
          headers: { "X-CSRF-TOKEN": token, Accept: "application/json" },
        });
        const json = await res.json();

        if (json.success) {
          cuerpoEl.innerHTML = `
            <p class="text-success text-center fw-bold">${json.message}</p>`;
          cargarClasesDisponibles();
          mostrarCalendario();
          actualizarMetricas();
          setTimeout(() => modal.hide(), 900);
        } else {
          cuerpoEl.innerHTML = `
            <p class="text-warning text-center fw-bold">${json.message}</p>`;
        }
      } catch {
        cuerpoEl.innerHTML = `
          <p class="text-danger text-center fw-bold">
            Error al procesar la inscripción.
          </p>`;
      }
    },
    { once: true }
  );
}

window.inscribirse = inscribirse;
