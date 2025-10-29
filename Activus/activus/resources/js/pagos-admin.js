// ==============================
// PAGOS – ADMINISTRATIVO (LARAVEL)
// ==============================
document.addEventListener("DOMContentLoaded", async () => {
  if (!document.getElementById("listaPagos")) return;

  // ==============================
  // FUNCIONES GLOBALES
  // ==============================

  function mostrarModal(icon, title, text) {
    Swal.fire({
      icon,
      title,
      text,
      confirmButtonColor: '#3085d6',
      background: '#1e1e2f',
      color: '#fff'
    });
  }

  function limpiarBackdrop() {
    setTimeout(() => {
      document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
      document.body.classList.remove('modal-open');
      document.body.style.removeProperty('overflow');
      document.body.style.removeProperty('padding-right');
    }, 400);
  }

  async function fetchSeguro(url, options = {}, mostrarCarga = false) {
    try {
      if (mostrarCarga) {
        Swal.fire({
          title: 'Procesando...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading(),
          background: '#1e1e2f',
          color: '#fff'
        });
      }

      const headers = options.headers || {};
      headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

      const response = await fetch(url, { ...options, headers });
      if (!response.ok) throw new Error(`Error HTTP ${response.status}`);

      const data = await response.json();
      if (mostrarCarga) Swal.close();
      return data;
    } catch (error) {
      if (mostrarCarga) Swal.close();
      mostrarModal('error', 'Error de conexión', 'No se pudo completar la acción. Intenta nuevamente.');
      console.error("fetchSeguro →", error);
      return null;
    }
  }

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
    const data = await fetchSeguro(API.buscarSocio(tipo, valor));
    if (!data) return;

    if (data.success) {
      const s = data.socio;
      dni.value = s.DNI || '';
      idSocio.value = s.id || '';
      socio.value = `${s.Apellido ?? ''} ${s.Nombre ?? ''}`.trim();
    } else {
      mostrarModal('info', 'Socio no encontrado', 'Verifica el número de DNI o el ID ingresado.');
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
    const data = await fetchSeguro(API.membresias);
    if (!data) return;

    PLANES = data;
    membresiasContainer.innerHTML = "";
    PLANES.forEach(m => {
      membresiasContainer.insertAdjacentHTML("beforeend", `
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="${m.id}"
                id="mem${m.id}" data-precio="${m.precio}" data-duracion="${m.duracion}">
          <label class="form-check-label" for="mem${m.id}">
            ${m.nombre} — $${Number(m.precio).toLocaleString()}
          </label>
        </div>
      `);
    });
  }

  // ============================
  // CALCULAR MONTO Y VENCIMIENTO
  // ============================
  membresiasContainer?.addEventListener("change", () => {
    const seleccionadas = [...document.querySelectorAll("#membresiasContainer input:checked")];

    const total = seleccionadas.reduce((sum, chk) => sum + Number(chk.dataset.precio || 0), 0);
    montoTotal.value = total ? `$${total.toLocaleString()}` : "";

    if (seleccionadas.length > 0) {
      const hoy = fechaPago.value ? new Date(fechaPago.value + "T00:00:00") : new Date();
      const diasMax = Math.max(...seleccionadas.map(chk => Number(chk.dataset.duracion || 0)));
      const venc = new Date(hoy);

      const dia = venc.getDate();
      if (diasMax >= 28 && diasMax <= 31) {
        venc.setMonth(venc.getMonth() + 1);
      } else if (diasMax >= 89 && diasMax <= 92) {
        venc.setMonth(venc.getMonth() + 3);
      } else if (diasMax >= 180 && diasMax <= 190) {
        venc.setMonth(venc.getMonth() + 6);
      } else if (diasMax >= 360 && diasMax <= 370) {
        venc.setFullYear(venc.getFullYear() + 1);
      } else {
        venc.setDate(venc.getDate() + diasMax);
      }
      if (venc.getDate() < dia) venc.setDate(0);
      fechaVencimiento.value = venc.toISOString().split("T")[0];
    } else {
      fechaVencimiento.value = "";
    }
  });

  // ============================
  // LIMPIAR MODAL AL ABRIR
  // ============================
  modalPagoEl?.addEventListener("show.bs.modal", () => {
    if (fechaPago && !fechaPago.value) fechaPago.value = hoyLocal();
    if (fechaVencimiento) fechaVencimiento.value = "";
    if (montoTotal) montoTotal.value = "";
    membresiasContainer?.querySelectorAll("input").forEach(i => (i.checked = false));
  });

  // ============================
  // REGISTRO DE PAGO CON MODALES
  // ============================
  document.getElementById("formPago")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    Swal.fire({
      title: '¿Confirmar registro del pago?',
      text: 'El pago será guardado en la base de datos.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      background: '#1e1e2f',
      color: '#fff'
    }).then(async (result) => {
      if (!result.isConfirmed) return;

      const btnSubmit = document.querySelector("#formPago button[type='submit']");
      btnSubmit.disabled = true;
      btnSubmit.textContent = "Registrando...";

      const formData = new FormData(e.target);
      const seleccionadas = [...document.querySelectorAll("#membresiasContainer input:checked")];

      if (seleccionadas.length === 0) {
        mostrarModal('info', 'Selecciona una membresía', 'Debes elegir al menos una antes de registrar el pago.');
        btnSubmit.disabled = false;
        btnSubmit.textContent = "Registrar Pago";
        return;
      }

      seleccionadas.map(chk => chk.value).forEach(id => formData.append("membresias[]", id));

      const data = await fetchSeguro(API.agregar, { method: "POST", body: formData }, true);

      if (data && data.success) {
        mostrarModal('success', '¡Pago registrado!', data.message || 'El pago se guardó correctamente.');
        const modal = bootstrap.Modal.getInstance(modalPagoEl) || new bootstrap.Modal(modalPagoEl);
        modal.hide();
        limpiarBackdrop();
        e.target.reset();
        await cargarPagos();
      } else if (data && !data.success) {
        mostrarModal('error', 'Error al registrar', data.message || 'Verifica los datos del socio o la membresía.');
      }

      btnSubmit.disabled = false;
      btnSubmit.textContent = "Registrar Pago";
    });
  });

  // ============================
  // CARGAR Y RENDER PAGOS
  // ============================
  async function cargarPagos() {
    const data = await fetchSeguro(API.listar);
    if (!data) return;
    pagos = data;
    aplicarFiltros();
  }

  const basePorTipo = () => {
    if (!filtroTipo) return pagos;
    const tipo = filtroTipo.value;
    if (tipo === "hoy") return pagos.filter(p => p.fecha_pago === hoyLocal());
    if (tipo === "mes") return pagos.filter(p => (p.fecha_pago || '').startsWith(hoyLocal().slice(0, 7)));
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
      totalCantidad.textContent = "0";
      totalMonto.textContent = "$0 recaudados";
      return;
    }

    const ordenados = [...arr].sort((a, b) => String(b.fecha_pago).localeCompare(String(a.fecha_pago)));
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

    totalCantidad.textContent = ordenados.length;
    const suma = ordenados.reduce((acc, p) => acc + Number(p.monto || 0), 0);
    totalMonto.textContent = `$${suma.toLocaleString()} recaudados`;
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
