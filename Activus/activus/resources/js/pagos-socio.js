// ==============================
// PAGOS – SOCIO (ACTIVUS)
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  const lista = document.getElementById("listaPagos");
  const fechaDesde = document.getElementById("fechaDesde");
  const fechaHasta = document.getElementById("fechaHasta");
  const btnFiltrar = document.getElementById("btnFiltrar");
  const diasRestantesEl = document.getElementById("diasRestantes");
  const fechaVencimientoEl = document.getElementById("fechaVencimiento");
  let pagosData = [];

  // Renderiza la lista del historial
  const renderizarPagos = (pagos) => {
    if (!pagos.length) {
      lista.innerHTML = `<div class="text-secondary text-center py-2">
        No se encontraron pagos en el rango seleccionado.
      </div>`;
      return;
    }

    lista.innerHTML = pagos.map(p => `
      <div class="list-group-item bg-dark border-secondary text-light 
                  d-flex justify-content-between align-items-center">
        <div>
          <strong>${p.fecha}</strong><br>
          <span class="text-secondary">${p.metodo}</span>
        </div>
        <div class="text-end">
          <span class="fw-bold">$${parseFloat(p.monto).toLocaleString("es-AR")}</span><br>
          <small class="${p.estado === 'Activa' ? 'text-success' : 'text-warning'}">
            ${p.estado}
          </small>
        </div>
      </div>
    `).join('');
  };

  // Muestra la cantidad de días restantes y su color
  const actualizarIndicadorDias = (dias, vencimiento, estadoMembresia) => {
    let texto = '';
    let clase = '';

    if (!vencimiento || estadoMembresia === 'Inactiva') {
      texto = 'Vencida';
      clase = 'text-danger fw-bold';
      fechaVencimientoEl.textContent = 'Sin membresía activa';
    } else if (dias < 0) {
      texto = 'Vencida';
      clase = 'text-danger fw-bold';
      fechaVencimientoEl.textContent = `Venció el ${vencimiento}`;
    } else {
      texto = `${dias} día${dias === 1 ? '' : 's'}`;
      if (dias <= 7) {
        clase = 'text-warning fw-bold';
      } else {
        clase = 'text-success fw-bold';
      }
      fechaVencimientoEl.textContent = `Vence el ${vencimiento}`;
    }

    diasRestantesEl.textContent = texto;
    diasRestantesEl.className = `display-5 mb-0 ${clase}`;
  };

  // Carga datos desde el backend (Laravel)
  const cargarPagos = async () => {
    try {
      const res = await fetch("/pagos-socio/listar");
      const data = await res.json();

      if (!data.success) throw new Error(data.error);
      pagosData = data.pagos;

      // --- Membresía actual ---
      document.getElementById("precioMembresia").textContent =
        `$${parseFloat(data.membresia.precio).toLocaleString("es-AR")}`;
      document.getElementById("tipoMembresia").textContent = data.membresia.tipo;

      const estadoBadge = document.getElementById("estadoMembresia");
      estadoBadge.textContent = data.membresia.estado;
      estadoBadge.className = `badge ${data.membresia.estado === 'Activa' ? 'bg-success' : 'bg-secondary'}`;

      // --- Próximo pago ---
      const prox = data.proximoPago;
      actualizarIndicadorDias(prox.diasRestantes, prox.vencimiento, data.membresia.estado);

      // --- Historial completo al inicio ---
      renderizarPagos(pagosData);

    } catch (err) {
      console.error(err);
      lista.innerHTML = `<div class="text-danger text-center py-2">
        Error al cargar los datos.
      </div>`;
      diasRestantesEl.textContent = 'Error';
      diasRestantesEl.className = 'text-danger fw-bold';
      fechaVencimientoEl.textContent = '';
    }
  };

  //  Filtro por rango de fechas (sin pedir al servidor)
  btnFiltrar.addEventListener("click", () => {
    const desde = fechaDesde.value ? new Date(fechaDesde.value) : null;
    const hasta = fechaHasta.value ? new Date(fechaHasta.value) : null;

    //  Si no hay fechas cargadas, muestra todo
    if (!desde && !hasta) {
      renderizarPagos(pagosData);
      return;
    }

    const pagosFiltrados = pagosData.filter(p => {
      const fechaPago = new Date(p.fecha);
      return (!desde || fechaPago >= desde) && (!hasta || fechaPago <= hasta);
    });

    renderizarPagos(pagosFiltrados);
  });

  await cargarPagos();
});
