document.addEventListener("DOMContentLoaded", () => {

    const tablaUsuarios = new DataTable("#tablaUsuarios", {
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json" },
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        dom: 'lrtip',
        stateSave: false
    });

    const inputBuscar = document.getElementById("buscadorUsuarios");
    if (inputBuscar) {
        inputBuscar.addEventListener("keyup", () => {
            tablaUsuarios.search(inputBuscar.value).draw();
        });
    }
    
    const inputEstado = document.getElementById("estadoFiltro");
    const inputRol = document.getElementById("rolFiltro");
    const btnLimpiarFiltro = document.getElementById("btnLimpiarFiltro");

    function aplicarFiltros() {
        const estado = inputEstado.value;
        const rol = inputRol.value;
        const estadoColIndex = 5; 
        const rolColIndex = 4; 
        let filtrosActivos = false;
        
        tablaUsuarios.column(estadoColIndex).search('');
        tablaUsuarios.column(rolColIndex).search('');
        
        if (estado !== "aEstados") {

            tablaUsuarios.column(estadoColIndex).search(`^${estado}$`, true, false); 
            filtrosActivos = true;
        }

        if (rol !== "aRoles") {
            tablaUsuarios.column(rolColIndex).search(`^${rol}$`, true, false); 
            filtrosActivos = true;
        }

        if (filtrosActivos) {
            btnLimpiarFiltro.classList.remove("d-none");
        } else {
            btnLimpiarFiltro.classList.add("d-none");
        }

        tablaUsuarios.draw();
    }

    function limpiarFiltros() {
        inputEstado.value = "aEstados";
        inputRol.value = "aRoles";
        btnLimpiarFiltro.classList.add("d-none");
        aplicarFiltros();
    }

    inputEstado.addEventListener("change", aplicarFiltros);
    inputRol.addEventListener("change", aplicarFiltros);
    btnLimpiarFiltro.addEventListener("click", limpiarFiltros);



    const formUsuario = document.getElementById("formUsuario");

    if (formUsuario) {
        formUsuario.addEventListener("submit", async (e) => {
            e.preventDefault();

            
            const campos = ["nombreUsuario","apellidoUsuario","dniUsuario","telefonoUsuario","emailUsuario","rolUsuario"];
            campos.forEach(campo => {
                const input = document.getElementById(campo);
                const errorDiv = document.getElementById("error-" + campo);
                if(input) input.classList.remove("is-invalid");
                if(errorDiv) errorDiv.textContent = "";
            });

            try {
                const formData = new FormData(formUsuario);

                const res = await fetch("/usuarios/crear", {
                    method: "POST",
                    body: formData
                });

                const json = await res.json();

                if (res.ok && json.success) {

                    const modalUsuario = bootstrap.Modal.getInstance(document.getElementById('modalUsuario'));
                    modalUsuario.hide();

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



const modalEditar = document.getElementById('modalEditarUsuario');

modalEditar.addEventListener('show.bs.modal', function (e) {
    const btnUsuario = e.relatedTarget;

    const id = btnUsuario.getAttribute('data-id');
    const nombre = btnUsuario.getAttribute('data-nombre');
    const apellido = btnUsuario.getAttribute('data-apellido');
    const email = btnUsuario.getAttribute('data-email');
    const dni = btnUsuario.getAttribute('data-dni');
    const telefono = btnUsuario.getAttribute('data-telefono');
    const rol = btnUsuario.getAttribute('data-rol');

    modalEditar.querySelector('#nombreUsuarioEditar').value = nombre;
    modalEditar.querySelector('#apellidoUsuarioEditar').value = apellido;
    modalEditar.querySelector('#emailUsuarioEditar').value = email;
    modalEditar.querySelector('#dniUsuarioEditar').value = dni;
    modalEditar.querySelector('#telefonoUsuarioEditar').value = telefono;
    modalEditar.querySelector('#rolUsuarioEditar').value = rol;

    modalEditar.querySelector('#formEditarUsuario').action = `/usuarios/${id}`;

    const ruta = modalEditar.querySelector('#formEditarUsuario').action;
    
    
    
    if (formEditarUsuario) {
        formEditarUsuario.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const campos = [
            "nombreUsuarioEditar", "apellidoUsuarioEditar", "dniUsuarioEditar",
            "telefonoUsuarioEditar", "emailUsuarioEditar", "rolUsuarioEditar"
        ];

        campos.forEach(campo => {
            const input = document.getElementById(campo);
            const errorDiv = document.getElementById("error-" + campo);
            if (input) input.classList.remove("is-invalid");
            if (errorDiv) errorDiv.textContent = "";
        });
        
        try {
            const formData = new FormData(formEditarUsuario);
            formData.append("_method", "PUT"); 

            const res = await fetch(`/usuarios/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            

            const json = await res.json();

            if (res.ok && json.success) {
                    const modalUsuarioEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
                    modalUsuarioEditar.hide();

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

const botonesDesAct = document.querySelectorAll(".btn-desactivar");

botonesDesAct.forEach(btn => {
    btn.addEventListener("click", async () => {
        const id = btn.dataset.id;
        
            try {
                const res = await fetch(`/usuarios/${id}/cambiar-estado`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({})
                });

                if (!res.ok) throw new Error("Error en la respuesta del servidor");

                const json = await res.json();

                if (res.ok && json.success) {

                    const modalExitoEl = document.getElementById('modalExito');
                    const modalExito = bootstrap.Modal.getOrCreateInstance(modalExitoEl);
                    const modalExitoTitulo = document.getElementById("titulo-exito");
                    const modalExitoBtn = document.getElementById("btn-exito");

                    modalExitoTitulo.textContent = json.message;
                    modalExito.show();

                    modalExitoBtn.addEventListener("click", () => {
                        window.location.reload();
                    });
                
                
                if (json.estado === 1) {
                    btn.textContent = "Desactivar";
                } else {
                    btn.textContent = "Activar";
                }
                }

            } catch (error) {
                console.error("Error al cambiar el estado:", error);
                alert("Hubo un error al cambiar el estado del usuario.");
            }
        });
    });

    const modalEliminar = document.getElementById('modalEliminarUsuario');

    modalEliminar.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        const form = modalEliminar.querySelector('#formEliminarUsuario');
        form.action = `/usuarios/${id}`;
    });


});
