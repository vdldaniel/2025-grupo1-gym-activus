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
        html: text,
        confirmButtonColor: "var(--primary-element)",
        background: "var(--base-clr)",
        color: "var(--text-clr)",
      });
    } else {
      alert(`${title}\n\n${text}`);
    }
  }

  async function fetchSeguro(url, options = {}) {
    try {
      const headers = {
        Accept: "application/json",
        ...(csrfToken ? { "X-CSRF-TOKEN": csrfToken } : {}),
        ...(options.body && !options.headers?.["Content-Type"]
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
      mostrarModal("error", "Error", err.message);
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
  const infoMembresiaSocio = document.getElementById("infoMembresiaSocio");

  const fechaPagoInput = document.getElementById("fechaPago");
  const fechaVencimientoInput = document.getElementById("fechaVencimiento");

  const metodoSelect = document.getElementById("metodo");
  const montoTotalInput = document.getElementById("montoTotal");
  const observacionInput = document.getElementById("observacion");

  const membresiasContainer = document.getElementById("membresiasContainer");

  let pagos = [];
  let membresias = [];

  // ==============================
  // FORMATEOS
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
        "días": "día(s)",
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
  // CÁLCULO CORRECTO DE FECHA DE VENCIMIENTO
  // ==============================
  function calcularVenc(fechaInicio, cantidad, unidad) {
    if (!fechaInicio) return "";

    const [anio, mes, dia] = fechaInicio.split("-").map(Number);
    const d = new Date(anio, mes - 1, dia);

    const n = Number(cantidad);
    if (!n) return "";

    switch (unidad.toLowerCase()) {
      case "dias":
      case "días":
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
    }

    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, "0");
    const dd = String(d.getDate()).padStart(2, "0");

    return `${yyyy}-${mm}-${dd}`;
  }

  // ==============================
  // ACTUALIZAR MONTO + FECHA
  // ==============================
  function actualizarMontoYFecha() {
    const radio = document.querySelector('input[name="membresia"]:checked');

    if (!radio) {
      montoTotalInput.value = "";
      fechaVencimientoInput.value = "";
      return;
    }

    const m = membresias.find((x) => Number(x.id) === Number(radio.value));
    if (!m) return;

    const dur = m.duracion; // viene así del backend
    const uni = m.unidad;
    const prec = m.precio;

    montoTotalInput.value = formatearMoneda(prec);

    if (fechaPagoInput.value) {
      fechaVencimientoInput.value = calcularVenc(
        fechaPagoInput.value,
        dur,
        uni
      );
    }
  }

  // ==============================
  // RENDER MEMBRESÍAS
  // ==============================
  function renderMembresias() {
    membresiasContainer.innerHTML = "";

    if (!membresias.length) {
      membresiasContainer.innerHTML =
        '<p class="text-secondary small mb-0">No hay tipos de membresía configurados.</p>';
      return;
    }

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
            <span class="text-secondary small">
              ${m.duracion} ${unidadLegible(m.unidad)}
            </span>
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
  // MEMBRESÍA ACTIVA – INFO BAJO EL SOCIO
  // ==============================
  async function cargarMembresiaActiva(idSocio) {
    if (!infoMembresiaSocio) return;

    infoMembresiaSocio.textContent = "";
    infoMembresiaSocio.className = "form-text small";

    let data;
    try {
      data = await fetchSeguro(RUTAS.membresiaActiva(idSocio));
    } catch {
      infoMembresiaSocio.textContent =
        "No se pudo obtener la información de membresía del socio.";
      infoMembresiaSocio.classList.add("text-warning");
      return;
    }

    // Sin historial
    if (!data) {
      infoMembresiaSocio.innerHTML =
        "<span class='text-secondary'>Este socio aún no tiene historial de membresías.</span>";
      return;
    }

    const hoy = new Date().toISOString().slice(0, 10);
    const plan = membresias.find(
      (m) => Number(m.id) === Number(data.ID_Tipo_Membresia)
    );
    const nombrePlan = plan ? plan.nombre : `Membresía #${data.ID_Tipo_Membresia}`;
    const fechaFinLegible = formatearFecha(data.Fecha_Fin);

    // Activa o vencida
    if (data.Fecha_Fin >= hoy) {
      // Activa – llamativo
      infoMembresiaSocio.innerHTML = `
        <span class="badge bg-warning text-dark me-2">Membresía ACTIVA
        <span><strong>${nombrePlan}</strong> – vence el <strong>${fechaFinLegible}</strong>.</span></span>
      `;
    } else {
      // Última registrada (vencida)
      infoMembresiaSocio.innerHTML = `
        <span class="badge bg-secondary me-2">Sin membresía activa</span>
        <span>Última membresía: <strong>${nombrePlan}</strong> – venció el <strong>${fechaFinLegible}</strong>.</span>
      `;
    }
  }

  // ==============================
  // BUSCAR SOCIO
  // ==============================
  async function buscarSocio(params) {
    const query = new URLSearchParams(params).toString();
    const data = await fetchSeguro(`${RUTAS.buscarSocio}?${query}`);

    // Reset selección
    document
      .querySelectorAll('input[name="membresia"]')
      .forEach((r) => (r.checked = false));
    montoTotalInput.value = "";
    fechaVencimientoInput.value = "";

    if (data && data.success && data.socio) {
      idSocioInput.value = data.socio.id;
      dniInput.value = data.socio.DNI;
      socioInput.value = `${data.socio.Nombre} ${data.socio.Apellido}`;

      await cargarMembresiaActiva(data.socio.id);
    } else {
      socioInput.value = "";
      if (infoMembresiaSocio) {
        infoMembresiaSocio.textContent = "";
        infoMembresiaSocio.className = "form-text small text-secondary";
      }
    }
    

  }
  // ==============================
  // LIMPIAR BACKDROP DE BOOTSTRAP
  // ==============================
  function limpiarBackdrop() {
    setTimeout(() => {
      document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());

      document.body.classList.remove("modal-open");
      document.body.style.removeProperty("overflow");
      document.body.style.removeProperty("padding-right");
    }, 100);
  }


  // ==============================
  // SUBMIT
  // ==============================
  formPago.addEventListener("submit", async (e) => {
    e.preventDefault();

    const idSocio = idSocioInput.value;
    const fechaPago = fechaPagoInput.value;
    const metodo = metodoSelect.value;
    const observacion = observacionInput.value.trim();
    const radio = document.querySelector('input[name="membresia"]:checked');

    if (!idSocio)
      return mostrarModal("warning", "Falta socio", "Seleccione un socio.");
    if (!fechaPago)
      return mostrarModal("warning", "Falta fecha", "Ingrese la fecha de pago.");
    if (!radio)
      return mostrarModal(
        "warning",
        "Falta membresía",
        "Seleccione una membresía."
      );

    const m = membresias.find((x) => Number(x.id) === Number(radio.value));
    const dur = m.duracion;
    const uni = m.unidad;
    const fechaVenc = calcularVenc(fechaPago, dur, uni);

    const payload = {
      idSocio,
      fechaPago,
      metodo,
      observacion,
      idTipoMembresia: radio.value,
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
      fechaVencimientoInput.value = "";
      if (infoMembresiaSocio) {
        infoMembresiaSocio.textContent = "";
        infoMembresiaSocio.className = "form-text small text-secondary";
      }
      await cargarPagos();
      await cargarMembresias();
      const modal = bootstrap.Modal.getInstance(
        document.getElementById("modalPago")
      );
      if (modal) modal.hide();
      limpiarBackdrop();

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

  fechaPagoInput.addEventListener("change", actualizarMontoYFecha);

  membresiasContainer.addEventListener("click", (e) => {
    if (e.target.matches('input[name="membresia"]')) {
      actualizarMontoYFecha();
    }
  });

  // ==============================
  // INICIALIZACIÓN
  // ==============================
  fechaPagoInput.value = new Date().toISOString().slice(0, 10);
  await cargarMembresias();
  await cargarPagos();
});
