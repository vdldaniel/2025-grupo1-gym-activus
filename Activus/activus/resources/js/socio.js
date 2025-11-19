document.addEventListener("DOMContentLoaded", () => {

    const tablaSocios = new DataTable("#tablaSocios", {
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json" },
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        dom: 'lrtip',
        stateSave: false
    });

    const inputBuscarSocio = document.getElementById("buscadorSocios");
    if (inputBuscarSocio) {
        inputBuscarSocio.addEventListener("keyup", () => {
            tablaSocios.search(inputBuscarSocio.value).draw();
        });
    }

    const inputEstadoMembresia = document.getElementById("estadoMembresiaFiltro");
    const inputMembresia = document.getElementById("membresiaFiltro");
    const btnLimpiarFiltro = document.getElementById("btnLimpiarFiltro");

    function aplicarFiltros() {
        const estado = inputEstadoMembresia.value;
        const membresia = inputMembresia.value;
        const estadoColIndex = 5;
        const membresiaColIndex = 4;
        let filtrosActivos = false;

        tablaSocios.column(estadoColIndex).search('');
        tablaSocios.column(membresiaColIndex).search('');

        if (estado !== "aEstadosMembresia") {

            tablaSocios.column(estadoColIndex).search(estado, true, false);
            filtrosActivos = true;
        }

        if (membresia !== "aMembresias") {
            tablaSocios.column(membresiaColIndex).search(membresia, true, false);
            filtrosActivos = true;
        }

        if (filtrosActivos) {
            btnLimpiarFiltro.classList.remove("d-none");
        } else {
            btnLimpiarFiltro.classList.add("d-none");
        }

        tablaSocios.draw();
    }

    function limpiarFiltros() {
        inputEstadoMembresia.value = "aEstadosMembresia";
        inputMembresia.value = "aMembresias";
        btnLimpiarFiltro.classList.add("d-none");
        aplicarFiltros();
    }

    inputEstadoMembresia.addEventListener("change", aplicarFiltros);
    inputMembresia.addEventListener("change", aplicarFiltros);
    if (btnLimpiarFiltro) {
        btnLimpiarFiltro.addEventListener("click", limpiarFiltros);
    }



    const formSocio = document.getElementById("formSocio");

    if (formSocio) {
        formSocio.addEventListener("submit", async (e) => {
            e.preventDefault();


            const campos = ["nombreSocio", "apellidoSocio", "dniSocio", "telefonoSocio", "emailSocio", "fechaNacSocio", "membresiaSocio"];
            campos.forEach(campo => {
                const input = document.getElementById(campo);
                const errorDiv = document.getElementById("error-" + campo);
                if (input) input.classList.remove("is-invalid");
                if (errorDiv) errorDiv.textContent = "";
            });

            try {
                const formData = new FormData(formSocio);

                const res = await fetch("/socios/crear", {
                    method: "POST",
                    body: formData
                });

                const json = await res.json();

                if (res.ok && json.success) {

                    const modalSocio = bootstrap.Modal.getInstance(document.getElementById('modalSocio'));
                    modalSocio.hide();

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



    const modalEditarSocio = document.getElementById('modalEditarSocio');

    modalEditarSocio.addEventListener('show.bs.modal', function (e) {
        const btnSocio = e.relatedTarget;

        const id = btnSocio.getAttribute('data-id');
        const nombre = btnSocio.getAttribute('data-nombre');
        const apellido = btnSocio.getAttribute('data-apellido');
        const email = btnSocio.getAttribute('data-email');
        const dni = btnSocio.getAttribute('data-dni');
        const telefono = btnSocio.getAttribute('data-telefono');
        const fechaNac = btnSocio.getAttribute('data-fecha-nacimiento');

        modalEditarSocio.querySelector('#nombreSocioEditar').value = nombre;
        modalEditarSocio.querySelector('#apellidoSocioEditar').value = apellido;
        modalEditarSocio.querySelector('#emailSocioEditar').value = email;
        modalEditarSocio.querySelector('#dniSocioEditar').value = dni;
        modalEditarSocio.querySelector('#telefonoSocioEditar').value = telefono;
        modalEditarSocio.querySelector('#fechaNacSocioEditar').value = fechaNac;

        modalEditarSocio.querySelector('#formEditarSocio').action = `/socios/${id}`;

        const ruta = modalEditarSocio.querySelector('#formEditarSocio').action;

        const formEditarSocio = document.getElementById("formEditarSocio");

        if (formEditarSocio) {
            formEditarSocio.addEventListener("submit", async (e) => {
                e.preventDefault();

                const campos = [
                    "nombreSocioEditar", "apellidoSocioEditar", "dniSocioEditar",
                    "telefonoSocioEditar", "emailSocioEditar", "fechaNacSocioEditar",
                ];

                campos.forEach(campo => {
                    const input = document.getElementById(campo);
                    const errorDiv = document.getElementById("error-" + campo);
                    if (input) input.classList.remove("is-invalid");
                    if (errorDiv) errorDiv.textContent = "";
                });

                try {
                    const formData = new FormData(formEditarSocio);
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
                        const modalSocioEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditarSocio'));
                        modalSocioEditar.hide();

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

});

