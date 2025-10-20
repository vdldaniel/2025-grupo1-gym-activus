document.addEventListener("DOMContentLoaded", async () => {

    const teachersList = document.getElementById("ListadoProfesoresadmin");
    const searchInput = document.getElementById("BuscarProfesoresadmin");
    let profesores = [];


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

            // etiqueta del estado (activo/inactivo)
            const estadoBadge =
                p.Estado.toLowerCase() === "activo"
                    ? `<span class="badge bg-success ms-2">Activo</span>`
                    : `<span class="badge bg-secondary ms-2">Inactivo</span>`;

            card.innerHTML = `
                <div class="card p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2"">
                        <h5>${p.Nombre} ${p.Apellido} </h5>
                        ${estadoBadge}
                    </div>
                    <p class="mb-1"><i class="bi bi-envelope"></i> ${p.Email}</p>
                    <p class="mb-1"><i class="bi bi-telephone"></i> ${p.Telefono}</p>
                    <p class="mb-0"><i class="bi bi-calendar4-event"></i> ${p.clases_count ?? 0} clases asignadas</p>
                </div>
            `;
            teachersList.appendChild(card);
        });
    }


    searchInput.addEventListener("keyup", function () {
        const busqueda = normalizarTexto(searchInput.value);
        const filtrados = profesores.filter((p) =>
            normalizarTexto(`${p.Nombre} ${p.Apellido}`).includes(busqueda)
        );
        mostrarProfesores(filtrados);
    });


    function normalizarTexto(texto) {
        return texto
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
    }


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


    // Inicializar
    await cargarMetricas();
    await cargarProfesores();

});
