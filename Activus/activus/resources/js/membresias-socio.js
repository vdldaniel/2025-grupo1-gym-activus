document.addEventListener('DOMContentLoaded', function () {
    const contenedor = document.getElementById('vista-membresias');
    const tabla = contenedor.querySelector('#tablaMembresias');


    fetch('/membresias/socio')
        .then(response => response.json())
        .then(data => {
            tabla.innerHTML = '';

            // Si no hay membresias
            if (!data || data.length === 0) {
                const filaVacia = document.createElement('tr');
                filaVacia.innerHTML = `
                    <td colspan="2" class="text-center py-4 ">
                        No hay membresías disponibles
                    </td>
                `;
                tabla.appendChild(filaVacia);
                return;
            }

            // mostrar membresias
            data.forEach(membresia => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>
                        <strong>${membresia.Nombre_Tipo_Membresia}</strong><br>
                        <small >${membresia.Descripcion ?? ''}</small>
                    </td>
                    <td>$${Number(membresia.Precio).toLocaleString('es-AR')} ARS</td>
                `;
                tabla.appendChild(fila);
            });
        })
        .catch(error => {
            console.error('Error al obtener las membresías:', error);
            const filaError = document.createElement('tr');
            filaError.innerHTML = `
                <td colspan="2" class="text-center py-4 text-danger">
                    Error al cargar las membresías.
                </td>
            `;
            tabla.innerHTML = '';
            tabla.appendChild(filaError);
        });
});
