// resources/js/validarPerfil.js

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("editPerfil");

    if (!form) return;

    form.addEventListener("submit", function(e) {
        const nombre = document.getElementById("firstName").value.trim();
        const apellido = document.getElementById("lastName").value.trim();
        const telefono = document.getElementById("phone").value.trim();
        const errores = [];

        if (nombre === "") errores.push("El nombre es obligatorio.");
        if (apellido === "") errores.push("El apellido es obligatorio.");
        if (telefono !== "" && !/^\+?\d{6,15}$/.test(telefono))
            errores.push("El teléfono no es válido (solo números, opcional '+').");

        if (errores.length > 0) {
            e.preventDefault();
            alert(errores.join("\n"));
        }
    });
})
