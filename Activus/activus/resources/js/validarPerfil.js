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

document.addEventListener('DOMContentLoaded', () => {
    const formCorreo = document.getElementById('formCambiarCorreo');
    const formContrasenia = document.getElementById('formCambiarContrasenia');

    // === Validación para cambiar correo ===
    if (formCorreo) {
        formCorreo.addEventListener('submit', e => {
            const correo = document.getElementById('nuevoCorreo').value.trim();
            const errores = [];

            // Validación: campo vacío
            if (correo === '') {
                errores.push('El correo no puede estar vacío.');
            }

            // Validación: formato de email (expresión regular completa)
            const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (correo !== '' && !regexCorreo.test(correo)) {
                errores.push('Ingresá un correo electrónico válido (ej: nombre@dominio.com).');
            }

            // Mostrar errores si los hay
            if (errores.length > 0) {
                e.preventDefault();
                alert(errores.join('\n'));
            }
        });
    }

    // === Validación para cambiar contraseña ===
    if (formContrasenia) {
        formContrasenia.addEventListener('submit', e => {
            const actual = document.getElementById('contraseniaActual')?.value.trim() || '';
            const nueva = document.getElementById('nuevaContrasenia').value.trim();
            const confirmar = document.getElementById('confirmarContrasenia')?.value.trim() || '';
            const errores = [];

            // Validar campos vacíos
            if (actual === '') errores.push('Debés ingresar tu contraseña actual.');
            if (nueva === '') errores.push('Debés ingresar una nueva contraseña.');
            if (confirmar === '') errores.push('Debés confirmar la nueva contraseña.');

            // Validar longitud mínima
            if (nueva.length > 0 && nueva.length < 8) {
                errores.push('La nueva contraseña debe tener al menos 8 caracteres.');
            }

            // Validar complejidad
            const regexComplejidad = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_-]).{8,}$/;
            if (nueva.length >= 8 && !regexComplejidad.test(nueva)) {
                errores.push('La contraseña debe incluir mayúsculas, minúsculas, números y un carácter especial.');
            }

            // Validar coincidencia de confirmación
            if (nueva !== confirmar) {
                errores.push('Las contraseñas no coinciden.');
            }

            // Mostrar errores si existen
            if (errores.length > 0) {
                e.preventDefault();
                alert(errores.join('\n'));
            }
        });
    }
});

