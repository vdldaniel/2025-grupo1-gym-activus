document.addEventListener("DOMContentLoaded", () => {

    async function activarVistaEjercicios(tab) {
    const contenido = document.getElementById('contenedor-ejercicios');
    if (!contenido) return;

    document.querySelectorAll('.btn-ejercicio').forEach(btn => {
        btn.classList.remove('btn-agregar');
        btn.classList.add('btn-secundario');
    });

    const btnActivo = document.getElementById('btn' + tab.charAt(0).toUpperCase() + tab.slice(1));
    if (btnActivo) {
        btnActivo.classList.remove('btn-secundario');
        btnActivo.classList.add('btn-agregar');
    }

        try {
        let url = '';
        if (tab === 'listaEjercicios' || url == '/ejercicios') {
            url = '/ejercicios/lista';
        } else if (tab === 'tablaEjercicios' ) {
            url = '/ejercicios/gestion';
        } 

        contenido.innerHTML = `
            <div id="loader-ejercicios" class="d-flex flex-column align-items-center justify-content-center" 
                style="min-height: 300px; position: relative;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-secondary">Cargando ejercicios...</p>
            </div>
        `;

        await new Promise(r => setTimeout(r, 50));

        const res = await fetch(url);
        const html = await res.text();
        contenido.innerHTML = html;


        setTimeout(() => {
            const tabla = document.getElementById("contenedor-tabla");
            const contenedorLista = document.getElementById("contenedor-lista");

            if (tabla) {
                const tablaEjercicios = new DataTable("#tablaEjercicios", {
                    language: { url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json" },
                    responsive: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    dom: 'lrtip'
                });

                const inputBuscar = document.getElementById("buscadorEjercicios");
                const musculoFiltro = document.getElementById("musculoFiltro");
                const equipoFiltro = document.getElementById("equipoFiltro");
                const btnLimpiar = document.getElementById("btnLimpiarFiltro");

                inputBuscar?.addEventListener("keyup", () => {
                    tablaEjercicios.search(inputBuscar.value).draw();
                });

                function aplicarFiltros() {
                    const musculo = musculoFiltro.value;
                    const equipo = equipoFiltro.value;
                    const musculoCol = 2;
                    const equipoCol = 3;

                    tablaEjercicios.column(musculoCol).search('');
                    tablaEjercicios.column(equipoCol).search('');

                    if (musculo !== "aMusculos") {
                        tablaEjercicios.column(musculoCol).search(musculo, true, false);
                    }

                    if (equipo !== "aEquipos") {
                        tablaEjercicios.column(equipoCol).search(equipo, true, false);
                    }

                    btnLimpiar.classList.toggle(
                        "d-none",
                        musculo === "aMusculos" && equipo === "aEquipos"
                    );

                    tablaEjercicios.draw();
                }

                function limpiarFiltros() {
                    musculoFiltro.value = "aMusculos";
                    equipoFiltro.value = "aEquipos";
                    inputBuscar.value = "";
                    btnLimpiar.classList.add("d-none");
                    tablaEjercicios.search('').draw();
                    aplicarFiltros();
                }

                musculoFiltro?.addEventListener("change", aplicarFiltros);
                equipoFiltro?.addEventListener("change", aplicarFiltros);
                btnLimpiar?.addEventListener("click", limpiarFiltros);
            }

            else if (contenedorLista) {
                const inputBuscar = document.getElementById("buscadorEjercicios");
                const filtroMusculo = document.getElementById("musculoFiltro");
                const filtroEquipo = document.getElementById("equipoFiltro");
                const btnLimpiar = document.getElementById("btnLimpiarFiltro");

                async function cargarEjercicios() {
                    const query = new URLSearchParams({
                        buscar: inputBuscar.value.trim(),
                        musculo: filtroMusculo.value,
                        equipo: filtroEquipo.value
                    }).toString();

                    contenedorLista.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2">Cargando ejercicios...</p>
                        </div>
                    `;

                    try {
                        const res = await fetch(`/ejercicios/lista?${query}`);
                        contenedorLista.innerHTML = await res.text(); 
                    } catch (error) {
                        contenedorLista.innerHTML = "<p class='text-danger text-center'>Error al cargar los ejercicios.</p>";
                        console.error(error);
                    }

                    btnLimpiar.classList.toggle(
                        "d-none",
                        !inputBuscar.value && filtroMusculo.value === "aMusculos" && filtroEquipo.value === "aEquipos"
                    );
                }

                inputBuscar?.addEventListener("keyup", cargarEjercicios);
                filtroMusculo?.addEventListener("change", cargarEjercicios);
                filtroEquipo?.addEventListener("change", cargarEjercicios);
                btnLimpiar?.addEventListener("click", () => {
                    inputBuscar.value = "";
                    filtroMusculo.value = "aMusculos";
                    filtroEquipo.value = "aEquipos";
                    cargarEjercicios();
                });

                cargarEjercicios();
            }
        }, 100);
    } catch (error) {
        contenido.innerHTML = '<p class="text-danger">Error al cargar la vista.</p>';
        console.error(error);
    }
}

const btnLista = document.getElementById("btnListaEjercicios");
const btnTabla = document.getElementById("btnTablaEjercicios");
btnLista?.addEventListener("click", () => activarVistaEjercicios("listaEjercicios"));
btnTabla?.addEventListener("click", () => activarVistaEjercicios("tablaEjercicios"));



    const formEjercicio = document.getElementById("formEjercicio");

    if (formEjercicio) {
        formEjercicio.addEventListener("submit", async (e) => {
            e.preventDefault();


            const campos = ["nombreEjercicio","descripcionEjercicio","musculos","equipos","instrucciones","tips"];
            campos.forEach(campo => {
                const input = document.getElementById(campo);
                const errorDiv = document.getElementById("error-" + campo);
                if(input) input.classList.remove("is-invalid");
                if(errorDiv) errorDiv.textContent = "";
            });

            try {
                const formData = new FormData(formEjercicio);

                const res = await fetch("/ejercicios/crear", {
                    method: "POST",
                    body: formData
                });

                const json = await res.json();

                if (res.ok && json.success) {

                    const modalEjercicio = bootstrap.Modal.getInstance(document.getElementById('modalEjercicio'));
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

const modalEditarEjercicio = document.getElementById('modalEditarEjercicio');

modalEditarEjercicio.addEventListener('show.bs.modal', function (e) {
    const btnEjercicio = e.relatedTarget;

    const id = btnEjercicio.getAttribute('data-id');
    const nombre = btnEjercicio.getAttribute('data-nombre');
    const descripcion = btnEjercicio.getAttribute('data-descripcion');
    const musculos = JSON.parse(btnEjercicio.getAttribute('data-musculo'));
    const equipos = JSON.parse(btnEjercicio.getAttribute('data-equipo'));
    const instrucciones = btnEjercicio.getAttribute('data-instrucciones');
    const tips = btnEjercicio.getAttribute('data-tips');

    modalEditarEjercicio.querySelector('#nombreEjercicioEditar').value = nombre;
    modalEditarEjercicio.querySelector('#descripcionEjercicioEditar').value = descripcion;
    modalEditarEjercicio.querySelector('#instruccionesEditar').value = instrucciones;
    modalEditarEjercicio.querySelector('#tipsEditar').value = tips;

    const musculosSelect = modalEditarEjercicio.querySelector('#musculosEditar');
    const equiposSelect = modalEditarEjercicio.querySelector('#equiposEditar');

    if (musculosSelect) { musculosSelect.value = musculos; $(musculosSelect).trigger('change'); }
    if (equiposSelect) { equiposSelect.value = equipos; $(equiposSelect).trigger('change'); }

    modalEditarEjercicio.querySelector('#formEditarEjercicio').action = `/ejercicios/${id}`;

    const ruta = modalEditarEjercicio.querySelector('#formEditarEjercicio').action;

    const formEditarEjercicio = document.getElementById("formEditarEjercicio");

    if (formEditarEjercicio) {
        formEditarEjercicio.addEventListener("submit", async (e) => {
            e.preventDefault();

            const campos = [
                "nombreEjercicioEditar", "descripcionEjercicioEditar", "musculosEditar",
                "equiposEditar", "instruccionesEjercicioEditar", "tipsEjercicioEditar",
            ];

        campos.forEach(campo => {
            const input = document.getElementById(campo);
            const errorDiv = document.getElementById("error-" + campo);
            if (input) input.classList.remove("is-invalid");
            if (errorDiv) errorDiv.textContent = "";
        });
        
        try {
            const formData = new FormData(formEditarEjercicio);
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
                    const modalEjercicioEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditarEjercicio'));
                    modalEjercicioEditar.hide();

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




    const modalEliminarEjercicio = document.getElementById('modalEliminarEjercicio');

    modalEliminarEjercicio.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        const form = modalEliminarEjercicio.querySelector('#formEliminarEjercicio');
        form.action = `/ejercicios/${id}`;
    });


    activarVistaEjercicios("listaEjercicios");

});


$(document).ready(function() {

    $('#modalEjercicio').on('shown.bs.modal', function() {
        $('#equipos').select2({
            dropdownParent: $('#modalEjercicio'),
            placeholder: "Selecciona los equipos necesarios",
            allowClear: true,
            width: '100%',
            tags: false,
            maximumSelectionLength: 2,
            language: {
                maximumSelected: function (e) {
                    return "Solo puedes seleccionar " + e.maximum + " equipos.";
                }
            }
        });
    });

});



$(document).ready(function() {

    $('#modalEjercicio').on('shown.bs.modal', function() {
        $('#musculos').select2({
            dropdownParent: $('#modalEjercicio'),
            placeholder: "Selecciona los músculos trabajados",
            allowClear: true,
            width: '100%',
            tags: false,
            maximumSelectionLength: 2,
            language: {
                maximumSelected: function (e) {
                    return "Solo puedes seleccionar " + e.maximum + " músculos.";
                }
            }
        });
    });

});


$('#modalEditarEjercicio').on('shown.bs.modal', function () {

    $('#musculosEditar').select2({
        dropdownParent: $('#modalEditarEjercicio'),
            placeholder: "Selecciona los músculos trabajados",
            allowClear: true,
            width: '100%',
            tags: false,
            maximumSelectionLength: 2,
            language: {
                maximumSelected: function (e) {
                    return "Solo puedes seleccionar " + e.maximum + " músculos.";
                }
            }
    });

    $('#equiposEditar').select2({
        dropdownParent: $('#modalEditarEjercicio')
    });
});