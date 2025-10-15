document.addEventListener("DOMContentLoaded", () => {

    const tablaUsuarios = new DataTable("#tablaUsuarios", {
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        },
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


document.addEventListener("click", async (e) => {
    if (e.target.closest(".editar-btn")) {
        const btnUsuario = e.target.closest(".editar-btn");
        const idUsuario = btnUsuario.dataset.id;

        try {
            const res = await fetch(`/usuarios/${idUsuario}`);
            if (!res.ok) throw new Error("No se pudo obtener el usuario");

            const usuario = await res.json();

            
            document.getElementById("idUsuarioEditar").value = usuario.ID_Usuario ?? "";
            document.getElementById("nombreUsuarioEditar").value = usuario.Nombre ?? "";
            document.getElementById("apellidoUsuarioEditar").value = usuario.Apellido ?? "";
            document.getElementById("dniUsuarioEditar").value = usuario.DNI ?? "";
            document.getElementById("telefonoUsuarioEditar").value = usuario.Telefono ?? "";
            document.getElementById("emailUsuarioEditar").value = usuario.Email ?? "";

            const selectRol = document.getElementById("rolUsuarioEditar");
            if (selectRol && usuario.roles && usuario.roles.length > 0) {
                selectRol.value = usuario.roles[0].ID_Rol; 
            } else {
                selectRol.value = "";
            }


        } catch (error) {
            console.error(error);
            alert("Error al obtener los datos del usuario.");
        }
    }
});




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

            const usuarioId = document.getElementById("idUsuarioEditar").value;

            const res = await fetch(`/usuarios/${usuarioId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
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

    const botones = document.querySelectorAll(".btn-desactivar");

    botones.forEach(btn => {
        btn.addEventListener("click", async () => {
            const idUsuario = btn.dataset.id;

            try {
                const res = await fetch(`/usuarios/${idUsuario}/cambiar-estado`, {
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



});
