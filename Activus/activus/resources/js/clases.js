document.addEventListener('DOMContentLoaded', function () {
    MostrarCalendario();
    inicializarCambioDeVista();
});




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
                break;
            case 'programadas':
                seccionProgramadas.classList.remove('d-none');
                btnProgramadas.classList.add('active');
                break;
            case 'clases':
                seccionClases.classList.remove('d-none');
                btnClases.classList.add('active');
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
