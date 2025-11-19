document.addEventListener("DOMContentLoaded", () => {
    const btnNueva = document.getElementById("btnNuevaMembresia");
    const formMembresia = document.getElementById("formMembresia");
    const botonConfirmarEliminacion = document.getElementById("btnConfirmarEliminarMembresia");


    CargarMembresias(); // Cargar al iniciar


    btnNueva.addEventListener("click", function () {
        LimpiarErrores();
        LimpiarForm();

        formMembresia.dataset.mode = "create";
        document.querySelector(".modal-title").innerText = "Nueva Membresía";
        document.getElementById("btnCrearMembresia").innerText = "Crear Membresía";

        MostrarModalCreacion();
    });

    formMembresia.addEventListener("submit", function (evento) {
        ValidarCreacionMembresia(evento);
    });


    document.addEventListener("click", function (event) {
        const botonElim = event.target.closest(".btnEliminarMembresia");

        if (botonElim) {
            const idMembresia = botonElim.getAttribute("data-id");
            const modalEliminacion = document.getElementById("modalConfirmarEliminarMembresia");
            modalEliminacion.dataset.idmembresia = idMembresia;
        }
    });


    botonConfirmarEliminacion.addEventListener("click", function () {
        const modalEliminacion = document.getElementById("modalConfirmarEliminarMembresia");
        const idMembresia = modalEliminacion.dataset.idmembresia;

        if (idMembresia) {
            EliminacionMembresia(idMembresia);
        }
    });

    document.addEventListener("click", async function (event) {
        const botonEdit = event.target.closest(".btnEditarMembresia");
        LimpiarErrores();
        if (botonEdit) {
            const id = botonEdit.getAttribute("data-id");

            // modifico el modal para editar
            formMembresia.dataset.mode = "edit";
            formMembresia.dataset.id = id;

            await CargarMembresiaPorId(id);

            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalMembresia"));
            document.querySelector(".modal-title").innerText = "Editar Membresía";
            document.getElementById("btnCrearMembresia").innerText = "Guardar Cambios";

            modal.show();
        }
    });


});


function CargarMembresias() {

    return fetch("/admin/membresias/listar")
        .then(res => res.json())
        .then(res => {

            document.getElementById("metricTotalMembresias").innerText = res.total_membresias;
            document.getElementById("metricTotalMiembros").innerText = res.total_socios;

            MostrarTabla(res.data);
        })
        .catch(() => console.log("Error cargando membresías"));
}


async function CargarMembresiaPorId(id) {
    try {
        let res = await fetch(`/admin/membresias/${id}`);
        let response = await res.json();

        if (response.status !== "success") {
            console.error("Error:", response.message);
            return;
        }

        let data = response.data;

        document.getElementById("NombreMembresia").value = data.Nombre_Tipo_Membresia;
        document.getElementById("PrecioMembresia").value = data.Precio;
        document.getElementById("DuracionMembresia").value = data.Duracion;
        document.getElementById("UnidadDuracion").value = data.Unidad_Duracion;
        document.getElementById("DescripcionMembresia").value = data.Descripcion;

    } catch (err) {
        console.error("Error cargando membresía:", err);
    }
}



function MostrarTabla(lista) {
    const tbody = document.getElementById("tablamembresias-admin");
    tbody.innerHTML = "";

    lista.forEach(item => {
        const fila = `
            <tr>
                <td data-label="Nombre"><strong>${item.Nombre_Tipo_Membresia}</strong>
                    <small class="texto-secundario d-block">${item.Descripcion}</small>
                </td>
                <td data-label="Precio">$${item.Precio} ARS</td>
                <td data-label="Duración">${item.Duracion} ${item.Unidad_Duracion}</td>
                <td data-label="Miembros"><span class="badge bg-secondary">${item.socios_count}</span></td>
                <td data-label="Acciones">
                      <!-- BOTÓN EDITAR -->
        <button class="btn btn-link p-0 me-2 text-primary btnEditarMembresia"
                data-id="${item.ID_Tipo_Membresia}">
            <i class="bi bi-pencil-square"></i>
        </button>

        <!-- BOTÓN ELIMINAR -->
        <button class="btn btn-link p-0 text-danger btnEliminarMembresia"
                data-id="${item.ID_Tipo_Membresia}"
                data-bs-toggle="modal"
                data-bs-target="#modalConfirmarEliminarMembresia">
            <i class="bi bi-trash"></i>
        </button>
                </td>
            </tr>
        `;
        tbody.innerHTML += fila;
    });
}
function MostrarModalCreacion() {

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalMembresia"));
    modal.show();

}
function CerrarModalCreacion() {
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalMembresia"));
    modal.hide();

}

function ValidarCreacionMembresia(evento) {
    evento.preventDefault();

    let oknombre = ValidarNombre();
    let okprecio = ValidarPrecio();
    let okduracion = ValidarDuracion();
    let okunidad = ValidarUnidad();
    let okdescripcion = ValidarDescripcion();

    if (oknombre && okprecio && okduracion && okunidad && okdescripcion) {
        GuardarMembresia();
    }
}

async function GuardarMembresia() {
    LimpiarErrores();

    let datos = {
        Nombre_Tipo_Membresia: document.getElementById("NombreMembresia").value,
        Precio: document.getElementById("PrecioMembresia").value,
        Duracion: document.getElementById("DuracionMembresia").value,
        Unidad_Duracion: document.getElementById("UnidadDuracion").value,
        Descripcion: document.getElementById("DescripcionMembresia").value
    };

    const isEdit = formMembresia.dataset.mode === "edit";
    const url = isEdit
        ? `/admin/membresias/${formMembresia.dataset.id}`
        : "/admin/membresias";
    const method = isEdit ? "PUT" : "POST";

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
                const input = document.getElementById(campo === "Nombre_Tipo_Membresia" ? "NombreMembresia" : campo);
                const errorDiv = document.getElementById("Error" + (campo === "Nombre_Tipo_Membresia"
                    ? "NombreMembresia"
                    : campo));

                if (input) input.classList.add("is-invalid");
                if (errorDiv) errorDiv.innerHTML = mensajes.join(", ");
            });
            return;
        }

        if (json.status === "success") {

            CerrarModalCreacion();
            CargarMembresias();
            MostrarExito("¡Operación exitosa!", json.message);
            return;
        } else {
            MostrarError(json.message || "Ocurrió un error al guardar la membresía.");
        }

    } catch (err) {
        console.error("Error guardando:", err);
        MostrarError("Error inesperado. Verifica la conexión o intenta más tarde.");
    }
}



function ValidarNombre() {

    let Nombre = document.getElementById("NombreMembresia");
    let ErrorNombre = document.getElementById("ErrorNombreMembresia");
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]{2,}$/;
    if (Nombre.value.trim() === "") {

        Nombre.classList.add("is-invalid");
        Nombre.classList.remove("is-valid");
        ErrorNombre.innerHTML = "Debe ingresar un nombre.";
    } else if (!(regex.test(Nombre.value))) {
        Nombre.classList.add("is-invalid");
        Nombre.classList.remove("is-valid");
        ErrorNombre.innerHTML = "Nombre invalido,debe contener al menos 2 caracteres";

    } else {
        Nombre.classList.remove("is-invalid");
        Nombre.classList.add("is-valid");
        ErrorNombre.innerHTML = "";
        return true;
    }
}

function ValidarPrecio() {
    let Precio = document.getElementById("PrecioMembresia");
    let ErrorPrecio = document.getElementById("ErrorPrecioMembresia");
    const numero = parseFloat(Precio.value);
    if (Precio.value.trim() === "") {

        Precio.classList.add("is-invalid");
        Precio.classList.remove("is-valid");
        ErrorPrecio.innerHTML = "Debe ingresar un precio.";
    } else if (isNaN(numero) || numero <= 0) {
        Precio.classList.add("is-invalid");
        Precio.classList.remove("is-valid");
        ErrorPrecio.innerHTML = "Precio inválido, debe ser un número mayor que 0.";
    } else {
        Precio.classList.remove("is-invalid");
        Precio.classList.add("is-valid");
        ErrorPrecio.innerHTML = "";
        return true;
    }
}

function ValidarDuracion() {
    let Duracion = document.getElementById("DuracionMembresia");
    let ErrorDuracion = document.getElementById("ErrorDuracionMembresia");
    const regex = /^[1-9]\d*$/
    if (Duracion.value.trim() === "") {

        Duracion.classList.add("is-invalid");
        Duracion.classList.remove("is-valid");
        ErrorDuracion.innerHTML = "Debe ingresar una duracion.";
    } else if (!(regex.test(Duracion.value))) {
        Duracion.classList.add("is-invalid");
        Duracion.classList.remove("is-valid");
        ErrorDuracion.innerHTML = "Duracion invalida, debe ser un numero entero positivo.";

    } else {
        Duracion.classList.remove("is-invalid");
        Duracion.classList.add("is-valid");
        ErrorDuracion.innerHTML = "";
        return true;
    }

}
function ValidarUnidad() {
    let unidad = document.getElementById("UnidadDuracion");
    let errorUnidad = document.getElementById("ErrorUnidadDuracion");

    if (!unidad.value.trim()) {
        unidad.classList.add("is-invalid");
        errorUnidad.innerHTML = "Seleccione una unidad.";
        return false;
    }

    unidad.classList.remove("is-invalid");
    unidad.classList.add("is-valid");
    errorUnidad.innerHTML = "";
    return true;
}

function ValidarDescripcion() {
    let Descripcion = document.getElementById("DescripcionMembresia");
    let ErrorDescripcion = document.getElementById("ErrorDescripcionMembresia");

    if (Descripcion.value.trim() === "") {

        Descripcion.classList.add("is-invalid");
        Descripcion.classList.remove("is-valid");
        ErrorDescripcion.innerHTML = "Debe ingresar una descripcion.";
    } else if (Descripcion.value.trim().length < 5) {
        Descripcion.classList.add("is-invalid");
        Descripcion.classList.remove("is-valid");
        ErrorDescripcion.innerHTML = "Descripcion invalida, debe contenr al menos 5 caracteres";
    } else {
        Descripcion.classList.remove("is-invalid");
        Descripcion.classList.add("is-valid");
        ErrorDescripcion.innerHTML = "";
        return true;
    }


}

async function EliminacionMembresia(id) {
    const modal = document.getElementById("modalConfirmarEliminarMembresia");
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modal);

    try {
        let response = await fetch(`/admin/membresias/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        let json = await response.json();

        if (response.ok && json.status === "success") {
            modalBootstrap.hide();
            await CargarMembresias();
            MostrarExito("¡Eliminada!", json.message);
            return;
        }


        modalBootstrap.hide();
        MostrarError(json.message || "No se pudo eliminar la membresía");
        return;

    } catch (err) {
        MostrarError("Error inesperado al eliminar.");
        console.error(err);
    }
}


function LimpiarForm() {

    document.getElementById("formMembresia").reset();
    LimpiarErrores();
}

function LimpiarErrores() {
    var elementos = document.querySelectorAll("#formMembresia input, #formMembresia select, #formMembresia textarea");
    for (var i = 0; i < elementos.length; i++) {
        elementos[i].classList.remove("is-valid", "is-invalid");
    }

    var errores = document.querySelectorAll("#formMembresia .invalid-feedback");
    for (var j = 0; j < errores.length; j++) {
        errores[j].innerHTML = "";
    }
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
