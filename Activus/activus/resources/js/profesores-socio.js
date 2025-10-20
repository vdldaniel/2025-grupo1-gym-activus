document.addEventListener("DOMContentLoaded", async () => {


    const teachersList = document.getElementById("ListadoProfesores");
    const searchInput = document.getElementById("BuscarProfesores");

    let profesores = [];

    async function cargarProfesores() {
        try {
            const res = await fetch("/profesores/socio");
            profesores = await res.json();
            mostrarProfesores(profesores);
        } catch (error) {
            console.error("Error al cargar los profesores:", error);
            teachersList.innerHTML = `<p class="text-danger text-center">Error al cargar los datos.</p>`;
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
            card.dataset.name = `${p.Nombre} ${p.Apellido}`.toLowerCase();

            card.innerHTML = `
                <div class="card p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5>${p.Nombre} ${p.Apellido}</h5>
                    </div>
                    <p class="mb-1"><i class="bi bi-envelope"></i> ${p.Email}</p>
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


    await cargarProfesores();
});
