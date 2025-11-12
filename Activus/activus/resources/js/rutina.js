document.addEventListener("DOMContentLoaded", () => {

    const contenedorRutinas = document.getElementById("contenedor-rutinas");
    const inputBuscar = document.getElementById("buscadorRutinas");
    const filtroNivel = document.getElementById("nivelFiltro");

    async function cargarRutinas() {
        const query = new URLSearchParams({
            buscar: inputBuscar.value.trim(),
            nivelDificultad: filtroNivel.value
        }).toString();

        contenedorRutinas.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2">Cargando rutinas...</p>
            </div>
        `;
            try {
                const res = await fetch(`/rutinas/lista?${query}`);
                contenedorRutinas.innerHTML = await res.text(); 
            } catch (error) {
                contenedorRutinas.innerHTML = "<p class='text-danger text-center'>Error al cargar los ejercicios.</p>";
                console.error(error);
            }
}

    inputBuscar.addEventListener("input", cargarRutinas);
    filtroNivel.addEventListener("change", cargarRutinas);

    cargarRutinas();

const btnAgregarCrear = document.getElementById("btnAgregarEjercicioCrear");
const btnAgregarEditar = document.getElementById("btnAgregarEjercicioEditar");

if (btnAgregarCrear) {
    btnAgregarCrear.addEventListener("click", e => {
        e.preventDefault();
        agregarEjercicio("ejercicio-container");
    });
}

if (btnAgregarEditar) {
    btnAgregarEditar.addEventListener("click", e => {
        e.preventDefault();
        agregarEjercicio("ejercicio-container-editar");
    });
}

function agregarEjercicio(contenedorId) {
    const contenedor = document.getElementById(contenedorId);
    if (!contenedor) return;

    const selectBase = contenedor.closest('.modal')?.querySelector("#ejercicioRutina");
    if (!selectBase) {
        console.error("No se encontró el select de ejercicios");
        return;
    }

    const opciones = Array.from(selectBase.options)
        .map(opt => `<option value="${opt.value}">${opt.text}</option>`)
        .join("");

    const nuevoBloque = document.createElement("div");
    nuevoBloque.classList.add("row", "g-2", "mt-2", "ejercicio-bloque");
    nuevoBloque.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="mb-3 col-12 col-md-12">
                <label class="form-label">Ejercicio</label>
                <select class="form-select card-input" name="${contenedorId === 'ejercicio-container' ? 'ejercicioRutina[]' : 'ejercicioRutinaEditar[]'}" required>
                    ${opciones}
                </select>
            </div>
            <div class="mb-3 col-6 col-md-6">
                <label class="form-label">Series</label>
                <input type="number" name="${contenedorId === 'ejercicio-container' ? 'seriesRutina[]' : 'seriesRutinaEditar[]'}" class="form-control card-input" placeholder="45" required>
            </div>
            <div class="mb-3 col-6 col-md-6">
                <label class="form-label">Repeticiones</label>
                <input type="number" name="${contenedorId === 'ejercicio-container' ? 'repeticionesRutina[]' : 'repeticionesRutinaEditar[]'}" class="form-control card-input" placeholder="1" required>
            </div>
            <div class="col-12 text-end">
                <button type="button" class="btn btn-danger btn-sm btn-quitar">Quitar</button>
            </div>
        </div>
    `;
    contenedor.appendChild(nuevoBloque);

    nuevoBloque.querySelector(".btn-quitar").addEventListener("click", () => nuevoBloque.remove());
}






    const formRutina = document.getElementById("formRutina");

    if (formRutina) {
        formRutina.addEventListener("submit", async (e) => {
            e.preventDefault();

            const campos = ["nombreRutina","descripcionRutina","dificultadRutina","diasRutina","duracionRutina","ejercicioRutina","seriesRutina","repeticionesRutinas"];
            campos.forEach(campo => {
                const input = document.getElementById(campo);
                const errorDiv = document.getElementById("error-" + campo);
                if(input) input.classList.remove("is-invalid");
                if(errorDiv) errorDiv.textContent = "";
            });

            try {
                const formData = new FormData(formRutina);
                const res = await fetch("/rutinas/crear", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const json = await res.json();

                if (res.ok && json.success) {

                    const modalEjercicio = bootstrap.Modal.getInstance(document.getElementById('modalRutina'));
                    modalEjercicio.hide();

                    const modalExitoEl = document.getElementById('modalExito');
                    const modalExito = bootstrap.Modal.getOrCreateInstance(modalExitoEl);
                    const modalExitoTitulo = document.getElementById("titulo-exito");
                    const modalExitoBtn = document.getElementById("btn-exito");

                    modalExitoTitulo.textContent = json.message;
                    modalExito.show();

                    modalExitoBtn.addEventListener("click", () => {
                        window.location.reload();
                    });


                } else if (res.status === 422) {
                    
                    Object.entries(json.errors).forEach(([campo, mensajes]) => {
                        const input = document.getElementById(campo);
                        const errorDiv = document.getElementById("error-" + campo);
                        if (input) input.classList.add("is-invalid");
                        if (errorDiv) errorDiv.textContent = mensajes.join(", ");
                    });
                } else {
                    
                    alert(json.message || "Error inesperado");
                }


            } catch (error) {
                console.error(error);
                alert("Error de conexión o del servidor.");
            }
        });
    }

    
const modalEditarRutina = document.getElementById('modalEditarRutina');

modalEditarRutina.addEventListener('show.bs.modal', function (e) {
    const btnRutina = e.relatedTarget;

    const id = btnRutina.getAttribute('data-id');
    const nombre = btnRutina.getAttribute('data-nombre');
    const descripcion = btnRutina.getAttribute('data-descripcion');
    const dificultad = btnRutina.getAttribute('data-dificultad');
    const dias = btnRutina.getAttribute('data-dias');
    const duracion = btnRutina.getAttribute('data-duracion');
    const ejercicios = JSON.parse(btnRutina.getAttribute('data-ejercicio') || '[]');
    const series = JSON.parse(btnRutina.getAttribute('data-serie'));
    const repeticiones = JSON.parse(btnRutina.getAttribute('data-repeticion'));

    modalEditarRutina.querySelector('#nombreRutinaEditar').value = nombre;
    modalEditarRutina.querySelector('#descripcionRutinaEditar').value = descripcion;
    modalEditarRutina.querySelector('#dificultadRutinaEditar').value = dificultad;
    modalEditarRutina.querySelector('#diasRutinaEditar').value = dias;
    modalEditarRutina.querySelector('#duracionRutinaEditar').value = duracion;

    const contenedorEjerciciosEditar = modalEditarRutina.querySelector('#ejercicio-container-editar');
    contenedorEjerciciosEditar.innerHTML = '';

    ejercicios.forEach((ej, index) => {
        const nuevoBloque = document.createElement("div");
        nuevoBloque.classList.add("row", "g-2", "mt-2", "ejercicio-bloque");

        const opciones = Array.from(document.getElementById("ejercicioRutina").options)
            .map(opt => `<option value="${opt.value}" ${opt.value == ej ? 'selected' : ''}>${opt.text}</option>`)
            .join("");

    const mostrarBotonQuitar = index > 0;

    nuevoBloque.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="mb-3 col-12 col-md-12">
                <label class="form-label">Ejercicio</label>
                <select class="form-select card-input" name="ejercicioRutinaEditar[]" required>
                    ${opciones}
                </select>
            </div>
            <div class="mb-3 col-6 col-md-6">
                <label class="form-label">Series</label>
                <input type="number" name="seriesRutinaEditar[]" class="form-control card-input" value="${series[index]}" required>
            </div>
            <div class="mb-3 col-6 col-md-6">
                <label class="form-label">Repeticiones</label>
                <input type="number" name="repeticionesRutinaEditar[]" class="form-control card-input" value="${repeticiones[index]}" required>
            </div>
            <div class="col-12 text-end">
                ${mostrarBotonQuitar ? `<button type="button" class="btn btn-danger btn-sm btn-quitar">Quitar</button>` : ""}
            </div>
        </div>
    `;

    contenedorEjerciciosEditar.appendChild(nuevoBloque);


    if (mostrarBotonQuitar) {
        nuevoBloque.querySelector(".btn-quitar").addEventListener("click", () => {
            nuevoBloque.remove();
        });
    }

    });

    modalEditarRutina.querySelector('#formEditarRutina').action = `/rutinas/${id}`;

    const ruta = modalEditarRutina.querySelector('#formEditarRutina').action;

    const formEditarRutina = document.getElementById("formEditarRutina");

            if (formEditarRutina) {
                formEditarRutina.addEventListener("submit", async (e) => {
                    e.preventDefault();


            const campos = [
                "nombreRutinaEditar", "descripcionRutinaEditar", "dificultadRutinaEditar",
                "diasRutinaEditar", "duracionRutinaEditar", "ejercicioRutina", "seriesRutinaEditar",
                "repeticionesRutinaEditar"
            ];

        campos.forEach(campo => {
            const input = document.getElementById(campo);
            const errorDiv = document.getElementById("error-" + campo);
            if (input) input.classList.remove("is-invalid");
            if (errorDiv) errorDiv.textContent = "";
        });
        
        try {
            const formData = new FormData(formEditarRutina);
            formData.append("_method", "PUT"); 

            const res = await fetch(ruta, {
                method: "POST", 
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData
            });
            

            const json = await res.json();

            if (res.ok && json.success) {
                    const modalEditarRutina = bootstrap.Modal.getInstance(document.getElementById('modalEditarRutina'));
                    modalEditarRutina.hide();

                    const modalExitoEl = document.getElementById('modalExito');
                    const modalExito = bootstrap.Modal.getOrCreateInstance(modalExitoEl);
                    const modalExitoTitulo = document.getElementById("titulo-exito");
                    const modalExitoBtn = document.getElementById("btn-exito");
                    
                    modalExitoTitulo.textContent = json.message;
                    modalExito.show();

                    modalExitoBtn.addEventListener("click", () => {
                        window.location.reload();
                    });
            } else if (res.status === 422) {
                Object.entries(json.errors).forEach(([campo, mensajes]) => {
                    const input = document.getElementById(campo);
                    const errorDiv = document.getElementById("error-" + campo);
                    if (input) input.classList.add("is-invalid");
                    if (errorDiv) errorDiv.textContent = mensajes.join(", ");
                });
            } else {
                alert(json.message || "Error inesperado");
            }

        } catch (error) {
            console.error(error);
            alert("Error de conexión o del servidor.");
        }
    });

}
});



    const modalEliminarRutina = document.getElementById('modalEliminarRutina');

    modalEliminarRutina.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        const form = modalEliminarRutina.querySelector('#formEliminarRutina');
        form.action = `/rutinas/${id}`;
    });



});
