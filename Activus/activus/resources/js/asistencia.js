async function cargarAsistencias() {
    try {
        const response = await fetch('/asistencia');
        const data = await response.json();

        const tablaAsistencias = document.getElementById('tablaAsistencias');
        const total = document.getElementById('totalIngresos');
        const fechaHoy = document.getElementById('fechaHoy');

        // fecha actual 
        const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        fechaHoy.textContent = new Date().toLocaleDateString('es-AR', opcionesFecha);

        // limpiar tabla
        tablaAsistencias.innerHTML = '';

        if (data.length > 0) {
            data.forEach(a => {
                const estadoClass = a.Resultado === 'Exitoso' ? 'badge-exitoso' : 'badge-denegado';
                const fila = `
                    <tr>
                        <td data-label="Nombre"><strong>${a.Nombre} ${a.Apellido}</strong></td>
                        <td data-label="DNI">${a.DNI}</td>
                        <td  data-label="Hora">${a.Hora}</td>
                        <td data-label="Estado"><span class="badge ${estadoClass}">${a.Resultado}</span></td>
                    </tr>
                `;
                tablaAsistencias.innerHTML += fila;
            });
            total.textContent = data.length;
        } else {
            tablaAsistencias.innerHTML = '<tr><td colspan="4" class="text-center">No hay ingresos registrados hoy</td></tr>';
            total.textContent = 0;
        }

    } catch (error) {
        console.error('Error al cargar asistencias:', error);
    }
}

// Carga inicial
document.addEventListener('DOMContentLoaded', () => {
    cargarAsistencias();

    //actualiza cada 10 segundos  (puede no estar) es para que se vayan actualizando los datos automaticamente,creo que hay una mejor forma con event en laravel
    setInterval(cargarAsistencias, 10000);
});
