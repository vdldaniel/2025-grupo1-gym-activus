document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("formIngreso");
    const inputDni = document.getElementById("dni");
    const salida = document.getElementById("resultado");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let dni = inputDni.value.trim();

        salida.innerHTML = "";

        if (dni === "") {
            salida.innerHTML = `<div class="alert alert-warning">Ingresá un DNI.</div>`;
            autoLimpiar();
            return;
        }


        salida.innerHTML = `
            <div class="text-center py-2">
                <div class="spinner-border" role="status"></div>
            </div>
        `;

        fetch("/ingreso/verificar", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ dni })
        })
            .then(res => res.json())
            .then(data => {


                inputDni.value = "";
                inputDni.focus();

                if (data.status === "error") {
                    salida.innerHTML = `<div class="alert alert-danger">${data.mensaje}</div>`;
                    autoLimpiar();
                    return;
                }

                if (data.status === "denegado") {
                    salida.innerHTML = `
                    <div class="alert alert-danger">
                        <strong>${data.mensaje}</strong>
                    </div>
                `;
                    autoLimpiar();
                    return;
                }

                if (data.status === "permitido") {
                    salida.innerHTML = `
                    <div class="card p-3 border-success">
                        <h5 class="text-success mb-1">${data.nombre} ${data.apellido}</h5>
                        <p class="mb-0">${data.mensaje}</p>
                    </div>
                `;
                    autoLimpiar();
                }

            })
            .catch(() => {
                salida.innerHTML = `<div class="alert alert-danger">Error inesperado.</div>`;
                autoLimpiar();
            });
    });

    function autoLimpiar() {
        setTimeout(() => {
            salida.innerHTML = "";
        }, 3000);
    }

});
