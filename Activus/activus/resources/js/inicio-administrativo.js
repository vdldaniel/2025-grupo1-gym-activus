/* ==========================================================
   Módulo: Inicio – Administrativo
   Proyecto: Activus Gym
   Autor: Esmilce Mendoza
   Descripción:
   Script para mostrar datos dinámicos en el panel de inicio
   del rol Administrativo. Consume el endpoint Laravel que
   devuelve totales y clases del día.
   ========================================================== */

document.addEventListener("DOMContentLoaded", async () => {
  // Referencias a elementos del DOM
  const totalSociosEl = document.getElementById("totalSocios");
  const variacionSociosEl = document.getElementById("variacionSocios");
  const totalClasesEl = document.getElementById("totalClases");
  const variacionClasesEl = document.getElementById("variacionClases");
  const listaHorarioHoyEl = document.getElementById("listaHorarioHoy");

  // Endpoint del resumen (asegurate que esté en routes/web.php)
  const API = "/inicio/administrativo/resumen";

  // Función que actualiza los datos del panel
  async function cargarDatos() {
    try {
      const res = await fetch(API);
      const data = await res.json();

      if (!data.success) throw new Error(data.error || "Error al obtener datos");

      // ====== Mostrar totales ======
      totalSociosEl.textContent = data.totalSocios ?? "--";
      totalClasesEl.textContent = data.totalClases ?? "--";

      variacionSociosEl.textContent =
        data.totalSocios > 0
          ? "Socios registrados actualmente."
          : "No hay socios registrados.";

      variacionClasesEl.textContent =
        data.totalClases > 0
          ? "Clases programadas para hoy."
          : "No hay clases activas hoy.";

      // ====== Renderizar lista de clases ======
      listaHorarioHoyEl.innerHTML = "";

      if (data.clasesHoy && data.clasesHoy.length > 0) {
        data.clasesHoy.forEach((clase) => {
          const li = document.createElement("li");
          li.classList.add("small", "mb-2");
          li.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <strong>${clase.Nombre_Clase}</strong><br>
                <small class="text-secondary">
                  ${clase.Profesor ? `Prof. ${clase.Profesor}` : "Sin asignar"}
                </small>
              </div>
              <span class="badge bg-success">
                ${clase.Hora_Inicio} - ${clase.Hora_Fin}
              </span>
            </div>
          `;
          listaHorarioHoyEl.appendChild(li);
        });
      } else {
        listaHorarioHoyEl.innerHTML = `<li class="text-secondary small">No hay clases programadas para hoy.</li>`;
      }
    } catch (error) {
      console.error("Error al cargar los datos del inicio:", error);
      totalSociosEl.textContent = "--";
      totalClasesEl.textContent = "--";
      listaHorarioHoyEl.innerHTML = `<li class="text-danger small">No se pudieron cargar los datos.</li>`;
    }
  }

  // Ejecutar al cargar la página
  await cargarDatos();

  // Actualizar automáticamente cada 5 minutos
  setInterval(cargarDatos, 5 * 60 * 1000);
});
