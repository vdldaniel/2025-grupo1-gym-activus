// ==============================
// PAGOS – ADMINISTRATIVO (LARAVEL)
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  if (!document.getElementById("listaPagos")) return;

  // ==============================
  // CONFIG
  // ==============================
  const RUTAS = {
    listar: "/pagos/listar",
    listarMembresias: "/pagos/listar_membresias",
    buscarSocio: "/pagos/buscar_socio",
    agregar: "/pagos/agregar",
    membresiaActiva: (id) => `/pagos/membresia_activa/${id}`,
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
      document.querySelectorAll(".modal-backdrop").forEach((b) => b.remove());
      document.body.classList.remove("modal-open");
      document.body.style.removeProperty("overflow");
      document.body.style.removeProperty("padding-right");
    }, 300);
  }

  async function fetchSeguro(url, options = {}) {
    try {
      const headers = {
        Accept: "application/json",
        ...(csrfToken ? { "X-CSRF-TOKEN": csrfToken } : {}),
        ...((options.body && !options.headers?.["Content-Type"])
          ? { "Content-Type": "application/json" }
          : {}),
        ...(options.headers || {}),
      };

      const resp = await fetch(url, {
        ...options,
        headers,
        credentials: "include",
      });

      const contentType = resp.headers.get("content-type") || "";
      if (!contentType.includes("application/json")) {
        if (!resp.ok) throw new Error(`Error ${resp.status}`);
        return null;
      }

      const data = await resp.json();
      if (!resp.ok) throw new Error(data?.message || data?.error);

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
  // ELEMENTOS DOM
  // ==============================
  const listaPagos = document.getElementById("listaPagos");
  const buscador = document.getElementById("buscador");
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

  let pagos = [];
  let membresias = [];

  // ==============================
  // FORMATOS
  // ==============================
  function formatearFecha(f) {
    if (!f) return "-";
    const d = new Date(f);
    return isNaN(d) ? f : d.toLocaleDateString("es-AR");
  }

  function formatearMoneda(v) {
    const n = Number(v);
    return isNaN(n)
      ? `$${v}`
      : n.toLocaleString("es-AR", {
          style: "currency",
          currency: "ARS",
          minimumFractionDigits: 0,
        });
  }

  function unidadLegible(u) {
    return (
      {
        dias: "día(s)",
        semanas: "semana(s)",
        meses: "mes(es)",
        años: "año(s)",
      }[u] || u
    );
  }

  // ==============================
  // RENDER PAGOS
  // ==============================
  function renderPagos(filtro = "") {
    const texto = filtro.toLowerCase().trim();
    const filtrados = pagos.filter(
      (p) =>
        String(p.id).includes(texto) ||
        String(p.dni).includes(texto) ||
        p.socio.toLowerCase().includes(texto) ||
        p.plan.toLowerCase().includes(texto)
    );

    listaPagos.innerHTML = "";

    if (!filtrados.length) {
      listaPagos.innerHTML =
        '<div class="text-secondary small">No hay pagos registrados.</div>';
      totalCantidad.textContent = "0";
      totalMonto.textContent = "$0";
      return;
    }

    let suma = 0;

    filtrados.forEach((p) => {
      suma += Number(p.monto);

      const item = document.createElement("div");
      item.className =
        "list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2";

      item.innerHTML = `
        <div class="d-flex flex-column">
          <span class="fw-semibold">${p.socio} (${p.dni})</span>
          <span class="text-secondary small">${p.plan} — ${p.metodo}</span>
          <span class="text-secondary small">Pago: ${formatearFecha(
            p.fecha_pago
          )} · Vence: ${formatearFecha(p.fecha_vencimiento)}</span>
        </div>
        <div class="text-end">
          <span class="fw-bold">${formatearMoneda(p.monto)}</span><br>
          <span class="badge bg-secondary">${p.estado}</span>
        </div>
      `;

      listaPagos.appendChild(item);
    });

    totalCantidad.textContent = filtrados.length;
    totalMonto.textContent = `${formatearMoneda(suma)} recaudados`;
  }

  async function cargarPagos() {
    const data = await fetchSeguro(RUTAS.listar);
    pagos = Array.isArray(data) ? data : [];
    renderPagos(buscador.value);
  }

  // ==============================
  // CÁLCULO FECHA DE VENCIMIENTO
  // ==============================
  function calcularVenc(fechaInicio, cantidad, unidad) {
    const d = new Date(fechaInicio + "T00:00:00");
    if (isNaN(d)) return "";

    const n = Number(cantidad);
    if (!n) return "";

    if (unidad === "dias") d.setDate(d.getDate() + n);
    else if (unidad === "semanas") d.setDate(d.getDate() + n * 7);
    else if (unidad === "meses") d.setMonth(d.getMonth() + n);
    else if (unidad === "años") d.setFullYear(d.getFullYear() + n);

    return d.toISOString().slice(0, 10);
  }

  function actualizarMontoYFecha() {
    const radio = document.querySelector('input[name="membresia"]:checked');
    if (!radio) {
      montoTotalInput.value = "";
      return;
    }

    const m = membresias.find((x) => Number(x.id) === Number(radio.value));
    if (!m) return;

    montoTotalInput.value = formatearMoneda(m.precio);

    const inputFecha = document.querySelector(
      `.fecha-vencimiento-membresia[data-id="${m.id}"]`
    );

    inputFecha.disabled = false;
    inputFecha.value = calcularVenc(fechaPagoInput.value, m.duracion, m.unidad);
  }

  // ==============================
  // RENDER MEMBRESÍAS
  // ==============================
  function renderMembresias() {
    membresiasContainer.innerHTML = "";

    membresias.forEach((m) => {
      const wrapper = document.createElement("div");

      wrapper.innerHTML = `
      <div class="border rounded p-2">
        <div class="form-check d-flex justify-content-between">
          <div>
            <input type="radio" class="form-check-input" 
                   name="membresia" value="${m.id}" id="memb_${m.id}">
            <label class="form-check-label" for="memb_${m.id}">
              ${m.nombre} — ${formatearMoneda(m.precio)}
            </label>
          </div>
          <span class="text-secondary small">${m.duracion} ${unidadLegible(
        m.unidad
      )}</span>
        </div>

        <div class="mt-2 ms-4">
          <label class="form-label small mb-1">Vence</label>
          <input type="date" disabled 
            class="form-control form-control-sm card-input fecha-vencimiento-membresia"
            data-id="${m.id}">
        </div>
      </div>
      `;

      membresiasContainer.appendChild(wrapper);
    });
  }

  async function cargarMembresias() {
    const data = await fetchSeguro(RUTAS.listarMembresias);
    membresias = Array.isArray(data) ? data : [];
    renderMembresias();
  }

  // ==============================
  // SOCIO + MEMBRESÍA ACTIVA
  // ==============================
  async function cargarMembresiaActiva(idSocio) {
    const data = await fetchSeguro(RUTAS.membresiaActiva(idSocio));
    if (!data) return;

    const radio = document.querySelector(
      `input[name="membresia"][value="${data.ID_Tipo_Membresia}"]`
    );

    if (radio) {
      radio.checked = true;
      actualizarMontoYFecha();

      const hoy = new Date().toISOString().slice(0, 10);
      if (data.Fecha_Fin >= hoy) {
        mostrarModal(
          "warning",
          "Membresía activa",
          "Este socio ya tiene una membresía activa. ¿Desea renovarla igualmente?"
        );
      }
    }
  }

  async function buscarSocio(params) {
    const query = new URLSearchParams(params).toString();
    const data = await fetchSeguro(`${RUTAS.buscarSocio}?${query}`);

    if (data.success && data.socio) {
      idSocioInput.value = data.socio.id;
      dniInput.value = data.socio.DNI;
      socioInput.value = `${data.socio.Nombre} ${data.socio.Apellido}`;

      await cargarMembresiaActiva(data.socio.id);
    } else {
      socioInput.value = "";
    }
  }

  // ==============================
  // SUBMIT
  // ==============================
  formPago.addEventListener("submit", async (e) => {
    e.preventDefault();

    const idSocio = idSocioInput.value.trim();
    const fechaPago = fechaPagoInput.value;
    const metodo = metodoSelect.value;
    const observacion = observacionInput.value.trim();
    const radio = document.querySelector('input[name="membresia"]:checked');

    if (!idSocio) return mostrarModal("warning", "Falta socio", "Seleccione un socio.");
    if (!fechaPago) return mostrarModal("warning", "Falta fecha", "Ingrese la fecha de pago.");
    if (!radio) return mostrarModal("warning", "Falta membresía", "Seleccione una membresía.");

    const fechaVenc = document.querySelector(
      `.fecha-vencimiento-membresia[data-id="${radio.value}"]`
    ).value;

    const payload = {
      idSocio: Number(idSocio),
      fechaPago,
      metodo,
      observacion,
      idTipoMembresia: Number(radio.value),
      fechaVencimiento: fechaVenc,
    };

    const data = await fetchSeguro(RUTAS.agregar, {
      method: "POST",
      body: JSON.stringify(payload),
    });

    if (data.success) {
      mostrarModal("success", "Pago registrado", data.message || "");
      formPago.reset();
      socioInput.value = "";
      montoTotalInput.value = "";
      await cargarPagos();
      await cargarMembresias();
      limpiarBackdrop();
      bootstrap.Modal.getInstance(document.getElementById("modalPago")).hide();
    }
  });

  // ==============================
  // EVENTOS
  // ==============================
  buscador.addEventListener("input", () => renderPagos(buscador.value));

  dniInput.addEventListener("input", () =>
    buscarSocio({ dni: dniInput.value.trim() })
  );

  idSocioInput.addEventListener("input", () =>
    buscarSocio({ id: idSocioInput.value.trim() })
  );

  fechaPagoInput.addEventListener("change", () => actualizarMontoYFecha());

  membresiasContainer.addEventListener("change", (e) => {
    if (e.target.matches('input[name="membresia"]')) actualizarMontoYFecha();
  });

  // ==============================
  // INICIALIZACIÓN
  // ==============================
  fechaPagoInput.value = new Date().toISOString().slice(0, 10);
  await cargarPagos();
  await cargarMembresias();
});
