

let profesores = [];
const teachersList = document.getElementById("ListadoProfesoresadmin");
const searchInput = document.getElementById("BuscarProfesoresadmin");




async function cargarProfesores() {
    try {
        const res = await fetch("/profesores/admin");
        profesores = await res.json();
        mostrarProfesores(profesores);
    } catch (error) {
        console.error("Error al cargar los profesores:", error);
        teachersList.innerHTML = `<p class="text-center">Error al cargar los datos.</p>`;
    }
}


function mostrarProfesores(lista) {
    teachersList.innerHTML = "";

    if (lista.length === 0) {
        teachersList.innerHTML = `<p class="text-center">No se encontraron profesores</p>`;
        return;
    }

    lista.forEach((p) => {
        const card = document.createElement("div");
        card.classList.add("col-md-4", "teacher-card");

        const estadoBadge =
            p.Estado.toLowerCase() === "activo"
                ? `<span class="badge bg-success ms-2">Activo</span>`
                : `<span class="badge bg-secondary ms-2">Inactivo</span>`;

        card.innerHTML = `
            <div class="card p-3 h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5>${p.Nombre} ${p.Apellido}</h5>
                    ${estadoBadge}
                </div>

                <p class="mb-1"><i class="bi bi-envelope"></i> ${p.Email}</p>
                <p class="mb-1"><i class="bi bi-telephone"></i> ${p.Telefono}</p>

                <p class="mb-0">
                    <a href="#" class="verClasesBase clase-chip" data-id="${p.ID_Usuario}">
                        <i class="bi bi-calendar4-event"></i>
                        ${p.clases_count ?? 0} clases asignadas
                    </a>
                </p>
            </div>
        `;
        teachersList.appendChild(card);
    });
}


function normalizarTexto(texto) {
    return texto
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
}


function configurarBuscador() {
    searchInput.addEventListener("keyup", () => {
        const busqueda = normalizarTexto(searchInput.value);
        const filtrados = profesores.filter((p) =>
            normalizarTexto(`${p.Nombre} ${p.Apellido}`).includes(busqueda)
        );
        mostrarProfesores(filtrados);
    });
}

// cargar metricas 
async function cargarMetricas() {
    try {
        const res = await fetch("/profesoresMetricas");
        const data = await res.json();

        document.getElementById("totalProfesores").innerText = data.totalProfesores;
        document.getElementById("profesoresActivos").innerText = data.profesoresActivos;
        document.getElementById("clasesAsignadas").innerText = data.clasesAsignadas;
    } catch (error) {
        console.error("Error al cargar las métricas:", error);
    }
}



async function cargarClasesBase(idProfesor) {
    const modalBody = document.getElementById("contenidoClasesBase");
    modalBody.innerHTML = "Cargando clases...";

    try {
        const res = await fetch(`/profesor/${idProfesor}/clasesBase`);
        const clases = await res.json();

        if (clases.length === 0) {
            modalBody.innerHTML = "<p>Este profesor no tiene clases asignadas.</p>";
        } else {
            modalBody.innerHTML = clases.map(c =>
                `
                <div class="border p-2 rounded mb-2">
                    <strong>${c.Nombre_Clase}</strong><br>
                    Capacidad máxima: ${c.Capacidad_Maxima}<br>
                    Programaciones: ${c.Clases_Programadas}
                </div>
                `
            ).join("") + `
                <div class="text-end mt-3">
                    <button id="btnIrClases" class="clase-chip">Ver Clases</button>
                </div>
            `;
        }

        new bootstrap.Modal(document.getElementById("modalClasesBase")).show();

    } catch (err) {
        modalBody.innerHTML = "<p>Error al cargar las clases del profesor.</p>";
    }
}



document.addEventListener("click", function (e) {

    // 
    if (e.target.classList.contains("verClasesBase")) {
        e.preventDefault();
        const id = e.target.dataset.id;
        cargarClasesBase(id);
    }

    if (e.target.id === "btnIrClases") {
        const ruta = document.getElementById("modalClasesBase").dataset.url;
        window.location.href = ruta;
    }
});




document.addEventListener("DOMContentLoaded", async () => {
    configurarBuscador();
    await Promise.all([cargarMetricas(), cargarProfesores()]);

});
