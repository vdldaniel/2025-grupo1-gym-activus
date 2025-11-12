document.addEventListener('DOMContentLoaded', function () {
    cargarMetricas();
    MostrarCalendario();
    inicializarCambioDeVista();

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btnVerAlumnos');
        if (!btn) return;

        const idClase = btn.getAttribute('data-id');
        cargarAlumnosClase(idClase);
    });
});


function cargarAlumnosClase(idClase) {
    fetch(`/clases-programadas/${idClase}/alumnos`)
        .then(res => res.json())
        .then(data => {
            const lista = document.getElementById('listaAlumnos');
            lista.innerHTML = '';

            if (data.length === 0) {
                lista.innerHTML = '<li class="list-group-item">Sin inscriptos confirmados</li>';
            } else {
                data.forEach(a => {
                    lista.insertAdjacentHTML('beforeend', `<li class="list-group-item">${a.nombre}</li>`);
                });
            }


            const modal = new bootstrap.Modal(document.getElementById('modalVerAlumnos'));
            modal.show();
        })
        .catch(err => console.error('Error al cargar alumnos:', err));
}


function inicializarCambioDeVista() {
    const btnHorario = document.getElementById('btnHorario');
    const btnProgramadas = document.getElementById('btnProgramadas');
    const btnClases = document.getElementById('btnClases');

    const seccionHorario = document.getElementById('seccionHorario');
    const seccionProgramadas = document.getElementById('seccionProgramadas');
    const seccionClases = document.getElementById('seccionClases');

    const cambiarVista = (vista) => {
        const botones = [btnHorario, btnProgramadas, btnClases];
        const secciones = [seccionHorario, seccionProgramadas, seccionClases];

        // Oculta todas las secciones
        secciones.forEach(s => s.classList.add('d-none'));
        // quita el estado activo de todos los botones
        botones.forEach(b => b.classList.remove('active'));

        switch (vista) {
            case 'horario':
                seccionHorario.classList.remove('d-none');
                btnHorario.classList.add('active');
                MostrarCalendario();
                break;
            case 'programadas':
                seccionProgramadas.classList.remove('d-none');
                btnProgramadas.classList.add('active');
                cargarClasesProgramadasProfesor()
                break;
            case 'clases':
                seccionClases.classList.remove('d-none');
                btnClases.classList.add('active');
                cargarClases();
                break;
        }
    };

    // Eventos
    btnHorario.addEventListener('click', () => cambiarVista('horario'));
    btnProgramadas.addEventListener('click', () => cambiarVista('programadas'));
    btnClases.addEventListener('click', () => cambiarVista('clases'));


}

function MostrarCalendario() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;


    fetch('/obtener/eventos')
        .then(response => response.json())
        .then(events => {
            let slotMin = '07:00:00';
            let slotMax = '21:00:00';

            if (events.length > 0) {

                const horasInicio = events.map(e => new Date(e.start));
                const horasFin = events.map(e => new Date(e.end));

                // la hora minima y maxima del total de clases (para no mostras tantas horas y ni clases)
                let minHora = Math.min(...horasInicio.map(h => h.getHours()));
                let maxHora = Math.max(...horasFin.map(h => h.getHours()));


                minHora = Math.max(minHora - 1, 0);
                maxHora = Math.min(maxHora + 1, 23);


                slotMin = `${minHora.toString().padStart(2, '0')}:00:00`;
                slotMax = `${maxHora.toString().padStart(2, '0')}:00:00`;
            }


            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                themeSystem: 'bootstrap5',
                initialView: 'timeGridWeek',
                firstDay: 1,
                allDaySlot: false,
                expandRows: true,
                nowIndicator: true,


                height: 'auto',
                contentHeight: 'auto',


                slotMinTime: slotMin,
                slotMaxTime: slotMax,
                slotDuration: '00:30:00',


                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: 'prev,next'
                },


                titleFormat: {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                },
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                dayHeaderFormat: { weekday: 'long' },

                buttonText: {
                    today: 'Hoy'
                },

                eventDidMount: function (info) {

                    info.el.style.whiteSpace = 'normal';
                    info.el.style.overflow = 'visible';
                    info.el.style.textOverflow = 'unset';
                },


                events: events,

                // en pantallas chicas solo se ve por dia
                windowResize: function () {
                    if (window.innerWidth < 768) {
                        calendar.changeView('timeGridDay');
                    } else {
                        calendar.changeView('timeGridWeek');
                    }
                },
            });

            calendar.render();
        })
        .catch(error => {
            console.error('Error al cargar los eventos:', error);
        });
}



function cargarClases() {
    fetch('/clases/listar')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('tablaClases');
            if (!tbody) return;

            tbody.innerHTML = '';

            data.forEach(c => {
                const fila = `
                    <tr>
                        <td>${c.nombre_clase}</td>
                         <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users me-2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        ${c.capacidad}
                    </td>
                    </tr>`;
                tbody.insertAdjacentHTML('beforeend', fila);
            });
        })
        .catch(err => console.error('Error al cargar clases:', err));
}

function cargarClasesProgramadasProfesor() {
    fetch('/clases-programadas/listar')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('tablaClasesProgramadas');
            if (!tbody) return;

            tbody.innerHTML = '';

            data.forEach(c => {
                const fila = `
                    <tr>
                        <td>${c.nombre_clase}</td>
                        <td>${c.capacidad}</td>
                        <td>${c.sala}</td>
                        <td>${c.fecha} &nbsp;|&nbsp; ${c.hora_inicio} - ${c.hora_fin}</td>
                        <td>
                            <button class="btn btn-sm btn-agregar btnVerAlumnos" 
                                    data-id="${c.id}" >
                                Ver Alumnos
                            </button>
                        </td>
                    </tr>`;
                tbody.insertAdjacentHTML('beforeend', fila);
            });
        })
        .catch(err => console.error('Error al cargar clases programadas:', err));
}
async function cargarMetricas() {
    try {
        const res = await fetch('/clases/metricas');
        const json = await res.json();

        if (json.ok) {
            document.getElementById('metricTotalClases').textContent = json.totalClases;
            document.getElementById('metricClasesHoy').textContent = json.clasesHoy;
        } else {
            console.error("Error al obtener métricas");
        }
    } catch (error) {
        console.error("Error de red:", error);
    }
}