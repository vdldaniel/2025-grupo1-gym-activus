document.addEventListener("DOMContentLoaded", () => {

    let tabla = new DataTable("#tablaAsistencias", {
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json" },
        pageLength: 10,
        dom: "lrtip"
    });

    async function cargarAsistencias() {
        let buscar = document.getElementById("buscarAsistencia").value;
        let desde = document.getElementById("desdeAsistencia").value;
        let hasta = document.getElementById("hastaAsistencia").value;
        let tipo = document.getElementById("tipoUsuario").value;

        const res = await fetch(`/asistencias/filtrar?buscar=${buscar}&desde=${desde}&hasta=${hasta}&tipo=${tipo}`);
        const json = await res.json();

        if (json.success) {
            tabla.clear();

            json.data.forEach(a => {
                tabla.row.add([
                    `${a.Nombre} ${a.Apellido}`,
                    a.DNI,
                    a.Fecha,
                    a.Hora,
                    a.Rol,
                    badgeResultado(a.Resultado)
                ]);
            });

            tabla.draw();
        }
    }

    document.getElementById("filtrarAsistencias").addEventListener("click", cargarAsistencias);

    cargarAsistencias();
});

function badgeResultado(estado) {
    let clase = {
        "Exitoso": "success",
        "Denegado": "danger"
    }[estado] || "secondary";

    return `<span class="badge bg-${clase}">${estado}</span>`;
}
