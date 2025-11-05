document.addEventListener("DOMContentLoaded", async () => {
  try {
    const resp = await fetch("/inicio-profesor/datos");
    const json = await resp.json();

    if (!json.success) throw new Error(json.error || "Error al cargar datos");

    const d = json.data;

    // Estadísticas generales
    document.getElementById("totalEstudiantes").textContent = d.totalEstudiantes ?? "-";
    document.getElementById("variacionEstudiantes").textContent = d.variacionEstudiantes ?? "-";
    document.getElementById("totalClases").textContent = d.totalClases ?? "-";
    document.getElementById("variacionClases").textContent = d.variacionClases ?? "-";

    // Clases del día
    const lista = document.getElementById("listaClasesHoy");
    lista.innerHTML = "";

    if (!d.clasesHoy || d.clasesHoy.length === 0) {
      lista.innerHTML = `<p class="text-secondary small mb-0">No hay clases programadas para hoy.</p>`;
      return;
    }

    d.clasesHoy.forEach(c => {
      lista.innerHTML += `
        <li class="mb-2 d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-circle-fill text-primary me-2"></i>
            <span>${c.nombre}</span>
            <p class="card-subtitle text-secondary small mb-0">
              ${c.hora_inicio} – ${c.hora_fin} | ${c.sala}
            </p>
          </div>
        </li>
      `;
    });

  } catch (e) {
    console.error("Error al cargar datos del profesor:", e);
  }
});
