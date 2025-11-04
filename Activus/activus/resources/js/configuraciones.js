window.onload = function () {
    const formConfiguracion = document.getElementById("formConfiguracionGym");

    if (formConfiguracion) {
        formConfiguracion.addEventListener("submit", function (evento) {
            ValidarConfiguracionGym(evento);
        });
    }
};

function ValidarConfiguracionGym(evento) {
    evento.preventDefault();
    LimpiarErrores();

    let okNombre = ValidarNombreGym();
    let okUbicacion = ValidarUbicacionGym();
    let okLogo = ValidarLogoGym();
    let okHorarios = ValidarHorariosGym();
    let okColores = ValidarColoresGym();

    if (okNombre && okUbicacion && okLogo && okHorarios && okColores) {

        document.getElementById("formConfiguracionGym").submit();
    }
}

function ValidarNombreGym() {
    const input = document.getElementById("NombreGym");
    const errorDiv = document.getElementById("ErrorNombreGym");
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]{2,}$/;

    if (input.value.trim() === "") {
        input.classList.add("is-invalid");
        errorDiv.innerHTML = "Debe ingresar el nombre del gimnasio.";
        return false;
    } else if (!regex.test(input.value.trim())) {
        input.classList.add("is-invalid");
        errorDiv.innerHTML = "El nombre debe contener al menos 2 caracteres válidos.";
        return false;
    } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        errorDiv.innerHTML = "";
        return true;
    }
}

function ValidarUbicacionGym() {
    const input = document.getElementById("Ubicacion");
    const errorDiv = document.getElementById("ErrorUbicacionGym");

    if (input.value.trim() === "") {
        input.classList.add("is-invalid");
        errorDiv.innerHTML = "Debe ingresar la ubicación del gimnasio.";
        return false;
    } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        errorDiv.innerHTML = "";
        return true;
    }
}

function ValidarLogoGym() {
    const input = document.getElementById("logogym");
    const errorDiv = document.getElementById("ErrorLogoGym");
    const existeLogo = input.dataset.existeLogo === "1";

    if (!input.files.length && !existeLogo) {
        input.classList.add("is-invalid");
        errorDiv.innerHTML = "Debe subir un logo del gimnasio.";
        return false;
    } else {
        input.classList.remove("is-invalid");
        errorDiv.innerHTML = "";
        return true;
    }
}
function ValidarHorariosGym() {
    const filas = document.querySelectorAll(".horario-row");
    let valido = true;

    filas.forEach(fila => {
        const habilitado = fila.querySelector('input[type="checkbox"]').checked;
        const apertura = fila.querySelector('input[name^="apertura["]');
        const cierre = fila.querySelector('input[name^="cierre["]');
        const nombreDia = fila.querySelector(".nombre-dia")?.textContent.trim() || "el día";

        const errorGeneral = fila.parentElement.querySelector(".ErrorHorario");



        errorGeneral.textContent = "";
        apertura.classList.remove("is-invalid", "is-valid");
        cierre.classList.remove("is-invalid", "is-valid");

        if (habilitado) {

            if (!apertura.value || !cierre.value) {
                errorGeneral.textContent = `Debe ingresar horario de apertura y cierre para el  día ${nombreDia}.`;
                errorGeneral.style.display = "block";
                apertura.classList.add("is-invalid");
                cierre.classList.add("is-invalid");
                valido = false;
            }

            else if (cierre.value <= apertura.value) {
                errorGeneral.textContent = `La hora de cierre debe ser posterior a la de apertura en el día ${nombreDia}.`;
                errorGeneral.style.display = "block";
                apertura.classList.add("is-invalid");
                cierre.classList.add("is-invalid");
                valido = false;
            }

            else {
                apertura.classList.add("is-valid");
                cierre.classList.add("is-valid");
            }
        } else {

            if (apertura.value || cierre.value) {
                errorGeneral.textContent = `El día ${nombreDia} tiene horarios cargados pero no está habilitado.`;
                errorGeneral.style.display = "block";
                apertura.classList.add("is-invalid");
                cierre.classList.add("is-invalid");
                valido = false;
            }
        }
    });

    return valido;
}



function ValidarColoresGym() {
    const selectColorFondo = document.getElementById("colorFondo");
    const inputColorElemento = document.getElementById("colorElemento");
    const errorDiv = document.getElementById("ErrorColorElemento");

    inputColorElemento.classList.remove("is-invalid", "is-valid");

    const colorFondoSeleccionado = selectColorFondo.options[selectColorFondo.selectedIndex].dataset.hex;
    const colorElemento = inputColorElemento.value.trim();

    if (colorFondoSeleccionado && colorElemento &&
        colorFondoSeleccionado.toLowerCase() === colorElemento.toLowerCase()) {
        inputColorElemento.classList.add("is-invalid");
        errorDiv.innerHTML = "El color de fondo y el de los elementos no pueden ser iguales.";
        return false;
    } else {
        inputColorElemento.classList.add("is-valid");
        errorDiv.innerHTML = "";
        return true;
    }
}

function LimpiarErrores() {
    const inputs = document.querySelectorAll("#formConfiguracionGym input");
    const errores = document.querySelectorAll("#formConfiguracionGym .invalid-feedback");

    inputs.forEach(input => input.classList.remove("is-invalid", "is-valid"));
    errores.forEach(div => div.innerHTML = "");
}
