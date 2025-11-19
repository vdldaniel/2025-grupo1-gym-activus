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
                    rolTexto(a.ID_Rol)
                ]);
            });

            tabla.draw();
        }
    }

    function rolTexto(id) {
        switch (id) {
            case 1: return "Administrador";
            case 2: return "Profesor";
            case 3: return "Administrativo";
            case 4: return "Socio";
            default: return "Desconocido";
        }
    }

    document.getElementById("filtrarAsistencias").addEventListener("click", cargarAsistencias);

    cargarAsistencias();
});
