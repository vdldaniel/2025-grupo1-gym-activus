// ==============================
// PAGOS – ADMINISTRATIVO (LARAVEL)
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  if (!document.getElementById("listaPagos")) return;

  const API = {
    listar: '/pagos/listar',
    membresias: '/pagos/listar_membresias',
    buscarSocio: (tipo, valor) => `/pagos/buscar_socio?${tipo}=${encodeURIComponent(valor)}`,
    agregar: '/pagos/agregar',
  };

  let PLANES = [];
  let pagos = [];

  const hoyLocal = () => {
    const d = new Date();
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}-${String(d.getDate()).padStart(2, "0")}`;
  };

  // ELEMENTOS DOM
  const lista = document.getElementById("listaPagos");
  const filtroTipo = document.getElementById("filtroTipo");
  const filtroRango = document.getElementById("filtroRango");
  const fechaDesde = document.getElementById("fechaDesde");
  const fechaHasta = document.getElementById("fechaHasta");
  const btnFiltrar = document.getElementById("btnFiltrar");
  const buscador = document.getElementById("buscador");
  const filtroEstado = document.getElementById("filtroEstado");
  const totalCantidad = document.getElementById("totalCantidad");
  const totalMonto = document.getElementById("totalMonto");

  const dni = document.getElementById("dni");
  const idSocio = document.getElementById("idSocio");
  const socio = document.getElementById("socio");
  const membresiasContainer = document.getElementById("membresiasContainer");
  const fechaPago = document.getElementById("fechaPago");
  const fechaVencimiento = document.getElementById("fechaVencimiento");
  const montoTotal = document.getElementById("montoTotal");
  const modalPagoEl = document.getElementById("modalPago");

  const toggleRango = () => {
    if (!filtroTipo || !filtroRango) return;
    filtroRango.classList.toggle("d-none", filtroTipo.value !== "rango");
  };

  // ============================
  // BUSCAR SOCIO
  // ============================
  async function buscarSocio(tipo, valor) {
    try {
      const res = await fetch(API.buscarSocio(tipo, valor));
      const data = await res.json();
      if (data.success) {
        const s = data.socio;
        if (dni) dni.value = s.DNI || '';
        if (idSocio) idSocio.value = s.id || '';
        if (socio) socio.value = `${s.Apellido ?? ''} ${s.Nombre ?? ''}`.trim();
      } else {
        alert("Socio no encontrado");
      }
    } catch (err) {
      console.error("Error buscando socio:", err);
    }
  }

  dni?.addEventListener("blur", () => {
    if (dni.value.trim() !== "") buscarSocio("dni", dni.value.trim());
  });
  idSocio?.addEventListener("blur", () => {
    if (idSocio.value.trim() !== "") buscarSocio("id", idSocio.value.trim());
  });

  // ============================
  // CARGAR MEMBRESÍAS
  // ============================
  async function cargarMembresias() {
    if (!membresiasContainer) return;
    try {
      const res = await fetch(API.membresias);
      PLANES = await res.json();
      membresiasContainer.innerHTML = "";
      PLANES.forEach(m => {
        membresiasContainer.insertAdjacentHTML("beforeend", `
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="${m.id}"
                   id="mem${m.id}" data-precio="${m.precio}" data-duracion="${m.duracion}">
            <label class="form-check-label" for="mem${m.id}">
              ${m.nombre} — $${Number(m.precio).toLocaleString()} (${m.duracion} días)
            </label>
          </div>
        `);
      });
    } catch (err) {
      console.error("Error al cargar membresías:", err);
    }
  }

  // ============================
  // CALCULAR MONTO Y VENCIMIENTO
  // ============================
  membresiasContainer?.addEventListener("change", () => {
    const seleccionadas = [...document.querySelectorAll("#membresiasContainer input:checked")];

    const total = seleccionadas.reduce((sum, chk) => sum + Number(chk.dataset.precio || 0), 0);
    if (montoTotal) montoTotal.value = total ? `$${total.toLocaleString()}` : "";

    if (seleccionadas.length > 0) {
      const hoy = fechaPago.value ? new Date(fechaPago.value) : new Date();
      const diasMax = Math.max(...seleccionadas.map(chk => Number(chk.dataset.duracion || 0)));
      const venc = new Date(hoy);
      venc.setDate(venc.getDate() + (isFinite(diasMax) ? diasMax : 0));
      if (fechaVencimiento) fechaVencimiento.value = venc.toISOString().split("T")[0];
    } else {
      if (fechaVencimiento) fechaVencimiento.value = "";
    }
  });

  // ============================
  // LIMPIAR MODAL AL ABRIR
  // ============================
  if (modalPagoEl) {
    modalPagoEl.addEventListener("show.bs.modal", () => {
      if (fechaPago && !fechaPago.value) fechaPago.value = hoyLocal(); // editable, solo sugerido
      if (fechaVencimiento) fechaVencimiento.value = "";
      if (montoTotal) montoTotal.value = "";
      membresiasContainer?.querySelectorAll("input").forEach(i => (i.checked = false));
    });
  }

  // ============================
  // GUARDAR NUEVO PAGO
  // ============================
  document.getElementById("formPago")?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    const seleccionadas = [...document.querySelectorAll("#membresiasContainer input:checked")];
    if (seleccionadas.length === 0) {
      alert("Seleccioná al menos una membresía.");
      return;
    }

    seleccionadas.map(chk => chk.value).forEach(id => formData.append("membresias[]", id));

    try {
      const res = await fetch(API.agregar, {
        method: "POST",
        body: formData,
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
      });
      const data = await res.json();

      if (data.success) {
        const modal = bootstrap.Modal.getInstance(modalPagoEl) || new bootstrap.Modal(modalPagoEl);
        modal.hide();
        setTimeout(() => {
          document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
          document.body.classList.remove('modal-open');
          document.body.style.removeProperty('overflow');
          document.body.style.removeProperty('padding-right');
        }, 400);

        await cargarPagos();
      } else {
        alert("Error al registrar pago: " + (data.error || "Desconocido"));
      }
    } catch (err) {
      console.error("Error registrando pago:", err);
      alert("Ocurrió un error al registrar el pago. Ver consola.");
    }
  });

  // ============================
  // CARGAR Y RENDER PAGOS
  // ============================
  async function cargarPagos() {
    try {
      const res = await fetch(API.listar);
      pagos = await res.json();
      aplicarFiltros();
    } catch (err) {
      console.error("Error cargando pagos:", err);
      if (lista) lista.innerHTML = `<p class="text-danger">Error al cargar pagos.</p>`;
    }
  }

  const basePorTipo = () => {
    if (!filtroTipo) return pagos;
    const tipo = filtroTipo.value;
    if (tipo === "hoy") return pagos.filter(p => p.fecha_pago === hoyLocal());
    if (tipo === "mes") return pagos.filter(p => (p.fecha_pago || '').startsWith(hoyLocal().slice(0,7)));
    if (tipo === "rango") {
      const d = fechaDesde?.value, h = fechaHasta?.value;
      if (d && h) return pagos.filter(p => p.fecha_pago >= d && p.fecha_pago <= h);
    }
    return pagos;
  };

  function aplicarFiltros() {
    let base = basePorTipo();
    const q = (buscador?.value || "").toLowerCase().trim();
    if (q) {
      base = base.filter(p =>
        (p.socio || '').toLowerCase().includes(q) ||
        (p.dni || '').includes(q) ||
        (p.plan || '').toLowerCase().includes(q)
      );
    }
    const est = filtroEstado?.value || "";
    if (est) base = base.filter(p => (p.estado || "").toLowerCase() === est.toLowerCase());
    render(base);
  }

  function badgeEstadoHtml(estado) {
    const e = (estado || "").toLowerCase();
    if (e === "activa") return `<span class="badge bg-success me-2">Activa</span>`;
    if (e === "pendiente") return `<span class="badge bg-warning text-dark me-2">Pendiente</span>`;
    if (e === "vencida") return `<span class="badge bg-danger me-2">Vencida</span>`;
    return "";
  }

  function render(arr) {
    if (!lista) return;
    lista.innerHTML = "";
    if (!arr.length) {
      lista.innerHTML = `<p class="text-secondary mb-0">No se encontraron pagos.</p>`;
      if (totalCantidad) totalCantidad.textContent = "0";
      if (totalMonto) totalMonto.textContent = "$0 recaudados";
      return;
    }

    const ordenados = [...arr].sort((a,b)=> String(b.fecha_pago).localeCompare(String(a.fecha_pago)));

    ordenados.forEach(p => {
      const badgeMetodo = `<span class="badge border text-white me-2">${p.metodo ?? ''}</span>`;
      const badgeEstado = badgeEstadoHtml(p.estado);
      const planTxt = p.plan ? `<p class="small text-info mb-1">${p.plan} — ${p.estado} — vence el ${p.fecha_vencimiento || 'sin fecha'}</p>` : "";

      lista.insertAdjacentHTML("beforeend", `
        <div class="list-group-item text-white border-secondary mb-2 rounded">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div class="flex-grow-1">
              <p class="fw-bold mb-1">${p.socio ?? ''}</p>
              ${planTxt}
              <p class="text-secondary small mb-1">DNI: ${p.dni ?? ''} – ${p.fecha_pago ?? ''}</p>
              ${p.observacion ? `<p class="small fst-italic mb-1">${p.observacion}</p>` : ""}
            </div>
            <div class="text-end">
              <div>${badgeMetodo}${badgeEstado}<span class="fw-bold">$${Number(p.monto || 0).toLocaleString()}</span></div>
            </div>
          </div>
        </div>
      `);
    });

    if (totalCantidad) totalCantidad.textContent = ordenados.length;
    const suma = ordenados.reduce((acc, p) => acc + Number(p.monto || 0), 0);
    if (totalMonto) totalMonto.textContent = `$${suma.toLocaleString()} recaudados`;
  }

  filtroTipo?.addEventListener("change", () => { toggleRango(); aplicarFiltros(); });
  btnFiltrar?.addEventListener("click", aplicarFiltros);
  buscador?.addEventListener("input", aplicarFiltros);
  filtroEstado?.addEventListener("change", aplicarFiltros);

  if (filtroTipo) filtroTipo.value = "mes";
  toggleRango();

  await cargarMembresias();
  await cargarPagos();
});
