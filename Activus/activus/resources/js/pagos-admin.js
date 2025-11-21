// ==============================
// PAGOS – ADMINISTRATIVO (LARAVEL)
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  // Si no estamos en la vista de pagos, no hacer nada
  if (!document.getElementById("listaPagos")) return;

  // ==============================
  // CONFIG
  // ==============================
  const RUTAS = {
    listar: "/pagos/listar",
    listarMembresias: "/pagos/listar_membresias",
    buscarSocio: "/pagos/buscar_socio",
    agregar: "/pagos/agregar",
  };

  const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");

  // ==============================
  // FUNCIONES GLOBALES
  // ==============================

  function mostrarModal(icon, title, text) {
    if (window.Swal) {
      Swal.fire({
        icon,
        title,
        text,
        confirmButtonColor: "var(--primary-element)",
        background: "var(--base-clr)",
        color: "var(--text-clr)",
      });
    } else {
      alert(`${title}\n\n${text}`);
    }
  }

  function limpiarBackdrop() {
  setTimeout(() => {
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
  }, 300);
}


  async function fetchSeguro(url, options = {}) {
    try {
      const baseHeaders = {
        Accept: "application/json",
      };

      if (csrfToken) {
        baseHeaders["X-CSRF-TOKEN"] = csrfToken;
      }

      if (options.body && !options.headers?.["Content-Type"]) {
        baseHeaders["Content-Type"] = "application/json";
      }

      const resp = await fetch(url, {
        ...options,
        headers: {
          ...baseHeaders,
          ...(options.headers || {}),
        },
        credentials: "include", // para enviar la sesión
      });

      // Si la respuesta no es JSON, tratamos de mostrar error genérico
      const contentType = resp.headers.get("content-type") || "";
      if (!contentType.includes("application/json")) {
        if (!resp.ok) {
          throw new Error(
            `Error ${resp.status}: el servidor no devolvió JSON válido`
          );
        }
        return null;
      }

      const data = await resp.json();

      if (!resp.ok) {
        const msg =
          data?.message ||
          data?.error ||
          `Error ${resp.status} al procesar la solicitud`;
        throw new Error(msg);
      }

      return data;
    } catch (err) {
      console.error("[fetchSeguro] Error:", err);
      mostrarModal(
        "error",
        "Error",
        err.message || "Ocurrió un error al comunicarse con el servidor."
      );
      throw err;
    }
  }

  // ==============================
  // ELEMENTOS DEL DOM
  // ==============================
  const listaPagos = document.getElementById("listaPagos");
  const buscador = document.getElementById("buscador");

  const filtroTipo = document.getElementById("filtroTipo");
  const filtroRango = document.getElementById("filtroRango");
  const fechaDesde = document.getElementById("fechaDesde");
  const fechaHasta = document.getElementById("fechaHasta");
  const btnFiltrar = document.getElementById("btnFiltrar");

  const totalCantidad = document.getElementById("totalCantidad");
  const totalMonto = document.getElementById("totalMonto");

  const formPago = document.getElementById("formPago");
  const dniInput = document.getElementById("dni");
  const idSocioInput = document.getElementById("idSocio");
  const socioInput = document.getElementById("socio");
  const fechaPagoInput = document.getElementById("fechaPago");
  const metodoSelect = document.getElementById("metodo");
  const montoTotalInput = document.getElementById("montoTotal");
  const observacionInput = document.getElementById("observacion");
  const membresiasContainer = document.getElementById("membresiasContainer");

  const modalPagoEl = document.getElementById("modalPago");
  const modalPago =
    modalPagoEl && window.bootstrap
      ? new bootstrap.Modal(modalPagoEl)
      : null;

  let pagos = [];
  let membresias = [];

  // ==============================
  // FORMATEOS
  // ==============================
  function formatearFecha(fecha) {
    if (!fecha) return "-";
    const d = new Date(fecha);
    if (isNaN(d.getTime())) return fecha;
    return d.toLocaleDateString("es-AR");
  }

  function formatearMoneda(valor) {
    if (valor == null) return "$0";
    const num = Number(valor);
    if (isNaN(num)) return `$${valor}`;
    return num.toLocaleString("es-AR", {
      style: "currency",
      currency: "ARS",
      minimumFractionDigits: 0,
    });
  }

  function unidadLegible(unidad) {
    switch (unidad) {
      case "dias":
        return "día(s)";
      case "semanas":
        return "semana(s)";
      case "meses":
        return "mes(es)";
      case "años":
        return "año(s)";
      default:
        return unidad || "";
    }
  }

  // ==============================
  // RENDER DE PAGOS
  // ==============================
  function renderPagos(filtroTexto = "") {
    const texto = filtroTexto.trim().toLowerCase();

    let filtrados = pagos;

    if (texto) {
      filtrados = pagos.filter((p) => {
        return (
          String(p.id).includes(texto) ||
          String(p.dni || "").includes(texto) ||
          String(p.socio || "").toLowerCase().includes(texto) ||
          String(p.plan || "").toLowerCase().includes(texto)
        );
      });
    }

    listaPagos.innerHTML = "";

    if (!filtrados.length) {
      listaPagos.innerHTML =
        '<div class="text-secondary small">No hay pagos registrados.</div>';
      totalCantidad.textContent = "0";
      totalMonto.textContent = "$0 recaudados";
      return;
    }

    let suma = 0;

    filtrados.forEach((pago) => {
      suma += Number(pago.monto || 0);

      const item = document.createElement("div");
      item.className =
        "list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2";

      item.innerHTML = `
        <div class="d-flex flex-column">
          <span class="fw-semibold">${pago.socio} (${pago.dni})</span>
          <span class="text-secondary small">${pago.plan} — ${pago.metodo}</span>
          <span class="text-secondary small">
            Pago: ${formatearFecha(pago.fecha_pago)} · Vence: ${formatearFecha(
        pago.fecha_vencimiento
      )}
          </span>
        </div>
        <div class="text-end">
          <span class="fw-bold">${formatearMoneda(pago.monto)}</span><br>
          <span class="badge bg-secondary">${pago.estado}</span>
        </div>
      `;

      listaPagos.appendChild(item);
    });

    totalCantidad.textContent = filtrados.length;
    totalMonto.textContent = `${formatearMoneda(suma)} recaudados`;
  }

  async function cargarPagos() {
    try {
      const data = await fetchSeguro(RUTAS.listar, {
        method: "GET",
      });

      pagos = Array.isArray(data) ? data : [];
      renderPagos(buscador.value);
    } catch (e) {
      console.error("Error cargando pagos:", e);
    }
  }

  // ==============================
  // FECHAS POR MEMBRESÍA
  // ==============================
  function calcularFechaVencimiento(fechaInicio, cantidad, unidad) {
    if (!fechaInicio || !cantidad) return "";
    const d = new Date(fechaInicio + "T00:00:00");
    if (isNaN(d.getTime())) return "";

    const n = Number(cantidad);
    if (!n || n <= 0) return "";

    switch (unidad) {
      case "dias":
        d.setDate(d.getDate() + n);
        break;
      case "semanas":
        d.setDate(d.getDate() + n * 7);
        break;
      case "meses":
        d.setMonth(d.getMonth() + n);
        break;
      case "años":
        d.setFullYear(d.getFullYear() + n);
        break;
      default:
        d.setDate(d.getDate() + n);
        break;
    }

    return d.toISOString().slice(0, 10);
  }

  function recalcularFechasVencimiento() {
    const fechaPago = fechaPagoInput.value;
    membresias.forEach((m) => {
      const check = document.querySelector(
        `input[name="membresias[]"][value="${m.id}"]`
      );
      const inputFecha = document.querySelector(
        `input.fecha-vencimiento-membresia[data-id-membresia="${m.id}"]`
      );
      if (!check || !inputFecha) return;

      if (!fechaPago || !check.checked) {
        inputFecha.disabled = true;
        inputFecha.value = "";
        return;
      }

      inputFecha.disabled = false;

      // Si no tiene fecha seteada manualmente, calculamos automática
      if (!inputFecha.value) {
        inputFecha.value = calcularFechaVencimiento(
          fechaPago,
          m.duracion,
          m.unidad
        );
      }
    });
  }

  // ==============================
  // MEMBRESÍAS
  // ==============================
  function renderMembresias() {
    if (!membresias.length) {
      membresiasContainer.innerHTML =
        '<p class="text-secondary small mb-0">No hay membresías configuradas.</p>';
      return;
    }

    membresiasContainer.innerHTML = "";

    membresias.forEach((membresia, index) => {
      const idCheck = `membresia_${membresia.id}`;
      const idFecha = `membresia_fecha_${membresia.id}`;

      const wrapper = document.createElement("div");

      wrapper.innerHTML = `
        <div class="border rounded p-2">
          <div class="form-check d-flex justify-content-between align-items-center">
            <div>
              <input class="form-check-input chk-membresia" type="checkbox"
                     name="membresias[]" value="${membresia.id}"
                     id="${idCheck}">
              <label class="form-check-label" for="${idCheck}">
                ${membresia.nombre} — ${formatearMoneda(membresia.precio)}
              </label>
            </div>
            <span class="text-secondary small">
              ${membresia.duracion} ${unidadLegible(membresia.unidad)}
            </span>
          </div>
          <div class="mt-2 ms-4">
            <label class="form-label small mb-1" for="${idFecha}">Vence</label>
            <input type="date"
                   class="form-control form-control-sm card-input fecha-vencimiento-membresia"
                   id="${idFecha}"
                   data-id-membresia="${membresia.id}"
                   disabled>
          </div>
        </div>
      `;

      membresiasContainer.appendChild(wrapper);
    });

    actualizarMontoYVencimiento();
    recalcularFechasVencimiento();
  }

  async function cargarMembresias() {
    try {
      const data = await fetchSeguro(RUTAS.listarMembresias, {
        method: "GET",
      });

      membresias = Array.isArray(data) ? data : [];
      renderMembresias();
    } catch (e) {
      console.error("Error cargando membresías:", e);
    }
  }

  function actualizarMontoYVencimiento() {
    const seleccionados = Array.from(
      document.querySelectorAll('input[name="membresias[]"]:checked')
    );
    let total = 0;

    seleccionados.forEach((chk) => {
      const id = Number(chk.value);
      const m = membresias.find((mm) => Number(mm.id) === id);
      if (!m) return;
      total += Number(m.precio || 0);
    });

    montoTotalInput.value = total ? formatearMoneda(total) : "";

    // Recalcular fechas para las seleccionadas
    recalcularFechasVencimiento();
  }

  // ==============================
  // BUSCAR SOCIO
  // ==============================
  let timeoutBusqueda = null;

  async function buscarSocio(params) {
    if (!params) return;

    try {
      const query = new URLSearchParams(params).toString();
      const data = await fetchSeguro(`${RUTAS.buscarSocio}?${query}`, {
        method: "GET",
      });

      if (data && data.success && data.socio) {
        idSocioInput.value = data.socio.id;
        socioInput.value = `${data.socio.Nombre} ${data.socio.Apellido}`;
        dniInput.value = data.socio.DNI;
      } else {
        socioInput.value = "";
      }
    } catch (e) {
      console.error("Error al buscar socio:", e);
    }
  }

  function programarBusquedaSocio(tipo) {
    clearTimeout(timeoutBusqueda);
    timeoutBusqueda = setTimeout(() => {
      if (tipo === "dni" && dniInput.value.trim()) {
        buscarSocio({ dni: dniInput.value.trim() });
      } else if (tipo === "id" && idSocioInput.value.trim()) {
        buscarSocio({ id: idSocioInput.value.trim() });
      }
    }, 400);
  }

  // ==============================
  // ENVÍO DE FORMULARIO
  // ==============================
  formPago.addEventListener("submit", async (e) => {
    e.preventDefault();

    const idSocio = idSocioInput.value.trim();
    const fechaPago = fechaPagoInput.value;
    const metodo = metodoSelect.value;
    const observacion = observacionInput.value.trim();

    if (!idSocio) {
      mostrarModal("warning", "Datos incompletos", "Debe seleccionar un socio.");
      return;
    }

    if (!fechaPago) {
      mostrarModal(
        "warning",
        "Datos incompletos",
        "Debe ingresar la fecha de pago."
      );
      return;
    }

    // Construimos los ítems (membresía + fecha propia)
    const items = [];
    const seleccionados = Array.from(
      document.querySelectorAll('input[name="membresias[]"]:checked')
    );

    if (!seleccionados.length) {
      mostrarModal(
        "warning",
        "Datos incompletos",
        "Debe seleccionar al menos una membresía."
      );
      return;
    }

    for (const chk of seleccionados) {
      const id = Number(chk.value);
      const inputFecha = document.querySelector(
        `input.fecha-vencimiento-membresia[data-id-membresia="${id}"]`
      );
      const fechaVencimiento = inputFecha?.value;

      if (!fechaVencimiento) {
        mostrarModal(
          "warning",
          "Fechas incompletas",
          "Verifique la fecha de vencimiento de cada membresía seleccionada."
        );
        return;
      }

      items.push({
        idTipoMembresia: id,
        fechaVencimiento,
      });
    }

    const payload = {
      idSocio: Number(idSocio),
      fechaPago,
      metodo,
      observacion,
      items,
    };

    try {
      const data = await fetchSeguro(RUTAS.agregar, {
        method: "POST",
        body: JSON.stringify(payload),
      });

      if (data && data.success) {
        mostrarModal("success", "Pago registrado", data.message || "");
        formPago.reset();
        socioInput.value = "";
        montoTotalInput.value = "";
        membresiasContainer.innerHTML =
          '<p class="text-secondary small mb-0">Cargando membresías disponibles...</p>';
        await Promise.all([cargarPagos(), cargarMembresias()]);
        if (modalPago) {
        modalPago.hide();
        limpiarBackdrop(); // <<<<<<<<<<<<<< AGREGA ESTO
      }

      } else {
        mostrarModal(
          "error",
          "Error al registrar",
          data?.message || "No se pudo registrar el pago."
        );
      }
    } catch (e) {
      console.error("Error al registrar pago:", e);
    }
  });

  function limpiarBackdrop() {
  setTimeout(() => {
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
  }, 300);
}


  // ==============================
  // EVENTOS
  // ==============================
  buscador?.addEventListener("input", () => {
    renderPagos(buscador.value);
  });

  filtroTipo?.addEventListener("change", () => {
    if (filtroTipo.value === "rango") {
      filtroRango.classList.remove("d-none");
    } else {
      filtroRango.classList.add("d-none");
      renderPagos(buscador.value);
    }
  });

  btnFiltrar?.addEventListener("click", () => {
    const desde = fechaDesde.value;
    const hasta = fechaHasta.value;

    if (!desde || !hasta) {
      mostrarModal(
        "warning",
        "Fechas incompletas",
        "Selecciona fecha desde y hasta."
      );
      return;
    }

    const fd = new Date(desde);
    const fh = new Date(hasta);
    const filtrados = pagos.filter((p) => {
      const fp = new Date(p.fecha_pago);
      return fp >= fd && fp <= fh;
    });

    listaPagos.innerHTML = "";
    if (!filtrados.length) {
      listaPagos.innerHTML =
        '<div class="text-secondary small">No hay pagos en ese rango.</div>';
      totalCantidad.textContent = "0";
      totalMonto.textContent = "$0 recaudados";
      return;
    }

    let suma = 0;
    filtrados.forEach((pago) => {
      suma += Number(pago.monto || 0);
    });

    totalCantidad.textContent = filtrados.length;
    totalMonto.textContent = `${formatearMoneda(suma)} recaudados`;
    renderPagos(buscador.value);
  });

  dniInput.addEventListener("input", () => programarBusquedaSocio("dni"));
  idSocioInput.addEventListener("input", () => programarBusquedaSocio("id"));

  fechaPagoInput.addEventListener("change", () => {
    recalcularFechasVencimiento();
  });

  membresiasContainer.addEventListener("change", (e) => {
    if (e.target.matches('input[name="membresias[]"]')) {
      // Si tilda/destilda, actualizamos monto y fechas
      actualizarMontoYVencimiento();
    }
  });

  // ==============================
  // INICIALIZACIÓN
  // ==============================
  // Fecha de pago por defecto = hoy
  const hoy = new Date().toISOString().slice(0, 10);
  if (fechaPagoInput) fechaPagoInput.value = hoy;

  await Promise.all([cargarPagos(), cargarMembresias()]);
});
