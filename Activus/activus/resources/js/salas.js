window.onload = function () {
    const btnNueva = document.getElementById("btnNuevaSala");
    const formSala = document.getElementById("formSala");
    const botonConfirmarEliminacion = document.getElementById("btnConfirmarEliminarSala");

    // cargar al iniciar
    CargarSalas();

    //modal modo crear
    btnNueva.addEventListener("click", function () {
        LimpiarForm();
        formSala.dataset.mode = "create";
        document.querySelector(".modal-title").innerText = "Nueva Sala";
        document.getElementById("btnCrearSala").innerText = "Crear Sala";
        MostrarModalSala();
    });


    formSala.addEventListener("submit", function (evento) {
        evento.preventDefault();
        ValidarSala();
    });


    document.addEventListener("click", function (event) {
        const botonElim = event.target.closest(".btnEliminarSala");
        if (botonElim) {
            const idSala = botonElim.getAttribute("data-id");
            const modal = document.getElementById("modalConfirmarEliminarSala");
            modal.dataset.idsala = idSala;
        }
    });


    botonConfirmarEliminacion.addEventListener("click", function () {
        const modal = document.getElementById("modalConfirmarEliminarSala");
        const idSala = modal.dataset.idsala;
        if (idSala) {
            EliminarSala(idSala);
        }
    });

    //modal modo editar
    document.addEventListener("click", async function (event) {
        const botonEdit = event.target.closest(".btnEditarSala");
        if (botonEdit) {
            const id = botonEdit.getAttribute("data-id");
            LimpiarErrores();

            formSala.dataset.mode = "edit";
            formSala.dataset.id = id;

            await CargarSalaPorId(id);

            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalSala"));
            document.querySelector(".modal-title").innerText = "Editar Sala";
            document.getElementById("btnCrearSala").innerText = "Guardar Cambios";
            modal.show();
        }
    });
};



async function CargarSalas() {
    try {
        const res = await fetch("/salas/listar");
        const salas = await res.json();
        MostrarTablaSalas(salas);
    } catch (err) {
        console.error("Error cargando salas:", err);
    }
}

async function CargarSalaPorId(id) {
    try {
        const res = await fetch(`/salas/listar`);
        const salas = await res.json();
        const sala = salas.find(s => s.ID_Sala == id);

        if (sala) {
            document.getElementById("NombreSala").value = sala.Nombre_Sala;
        }
    } catch (err) {
        console.error("Error cargando sala:", err);
    }
}
async function GuardarSala() {
    const formSala = document.getElementById("formSala");
    const datos = { NombreSala: document.getElementById("NombreSala").value };

    const isEdit = formSala.dataset.mode === "edit";
    const url = isEdit ? `/salas/${formSala.dataset.id}` : "/salas";
    const method = isEdit ? "PUT" : "POST";

    LimpiarErrores();

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(datos)
        });

        const json = await response.json();


        if (response.status === 422) {
            Object.entries(json.errors).forEach(([campo, mensajes]) => {
                const input = document.getElementById(campo);
                const errorDiv = document.getElementById("Error" + campo);

                if (input) input.classList.add("is-invalid");
                if (errorDiv) errorDiv.innerHTML = mensajes.join(", ");
            });
            return;
        }


        if (json.status === "success") {
            CerrarModalSala();
            CargarSalas();
            MostrarExito("Sala guardada correctamente");
            return;
        } else {
            MostrarError("Ocurrió un error al guardar la sala.");
        }
    } catch (err) {
        console.error(err);
        MostrarError("Error inesperado al guardar la sala.");
    }
}


async function EliminarSala(id) {
    try {
        const response = await fetch(`/salas/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const json = await response.json();

        if (response.ok && json.success) {
            CargarSalas();
            MostrarExito("Sala eliminada correctamente");
        } else {
            MostrarError("No se pudo eliminar la sala.");
        }
    } catch (err) {
        console.error(err);
        MostrarError("Error al eliminar la sala.");
    }
}

function MostrarTablaSalas(lista) {
    const tbody = document.getElementById("tablaSalas");
    tbody.innerHTML = "";


    if (!lista || lista.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="2" class="text-center text-secondary py-4">
                    <i class="bi bi-exclamation-circle"></i> No hay salas creadas todavía.
                </td>
            </tr>
        `;
        return;
    }


    lista.forEach(item => {
        const fila = `
            <tr>
                <td><strong>${item.Nombre_Sala}</strong></td>
                <td>
                    <button class="btn btn-link text-primary btnEditarSala" data-id="${item.ID_Sala}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-link text-danger btnEliminarSala"
                            data-id="${item.ID_Sala}"
                            data-bs-toggle="modal"
                            data-bs-target="#modalConfirmarEliminarSala">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.innerHTML += fila;
    });
}




function ValidarSala() {
    let nombre = document.getElementById("NombreSala");
    let error = document.getElementById("ErrorNombreSala");

    const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]{2,}$/;
    if (nombre.value.trim() === "") {
        nombre.classList.add("is-invalid");
        error.innerHTML = "Debe ingresar un nombre.";
    } else if (!regex.test(nombre.value)) {
        nombre.classList.add("is-invalid");
        error.innerHTML = "Nombre inválido, debe tener al menos 2 caracteres.";
    } else {
        nombre.classList.remove("is-invalid");
        nombre.classList.add("is-valid");
        error.innerHTML = "";
        GuardarSala();
    }
}

function LimpiarForm() {
    document.getElementById("formSala").reset();
    LimpiarErrores();
}

function LimpiarErrores() {
    const elementos = document.querySelectorAll("#formSala input");
    elementos.forEach(el => el.classList.remove("is-valid", "is-invalid"));
    document.getElementById("ErrorNombreSala").innerHTML = "";
}

function MostrarModalSala() {
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalSala"));
    modal.show();
}

function CerrarModalSala() {
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalSala"));
    modal.hide();
}


function MostrarExito(titulo = "Éxito", mensaje = "La operación se realizó con éxito") {
    const modalExito = document.getElementById("modalExito");

    document.getElementById("titulo-exito").innerText = titulo;

    const texto = modalExito.querySelector(".modal-body p");
    texto.innerText = mensaje;

    const instanciaModal = bootstrap.Modal.getOrCreateInstance(modalExito);
    instanciaModal.show();
}
function MostrarError(mensaje) {
    document.getElementById("mensaje-error").innerText = mensaje;
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalError"));
    modal.show();
}
