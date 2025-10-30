document.addEventListener("DOMContentLoaded", async () => {
  try {
    const respuesta = await fetch("/inicio-socio/obtener-datos");
    const data = await respuesta.json();
    console.log(" Datos recibidos:", data);

    if (!data.success) {
      console.error("Error en datos:", data.error);
      return;
    }

    // ============================
    //  MEMBRESÍA
    // ============================
    const tipoElem = document.getElementById("tipoMembresia");
    const precioElem = document.getElementById("precioMembresia");
    const estadoElem = document.getElementById("estadoMembresia");

    tipoElem.textContent = data.membresia.tipo || "Sin membresía activa";
    precioElem.textContent =
      data.membresia.precio && data.membresia.precio > 0
        ? `$${parseFloat(data.membresia.precio).toLocaleString("es-AR")}`
        : "$0";

    estadoElem.textContent = data.membresia.estado || "Inactiva";
    estadoElem.className = `badge rounded-pill ${
      data.membresia.estado === "Activa" ? "bg-success" : "bg-danger"
    }`;

    // ============================
    // PRÓXIMO PAGO
    // ============================
    const diasPagoElem = document.getElementById("diasProximoPago");
    const fechaPagoElem = document.getElementById("fechaProximoPago");

    const diasRestantes = parseInt(data.proximoPago.diasRestantes) || 0;
    diasPagoElem.textContent =
      diasRestantes > 0 ? `${diasRestantes} días` : "Vencido";

    diasPagoElem.className =
      diasRestantes <= 5
        ? "text-danger fw-bold display-4 mb-0"
        : "text-light display-4 mb-0";

    fechaPagoElem.textContent =
      data.proximoPago.vencimiento !== "Sin registros"
        ? `Vence el ${data.proximoPago.vencimiento}`
        : "Sin fecha registrada";

    // ============================
    //  CLASES DE HOY
    // ============================
    const clases = data.clasesHoy || [];
    const cantidadElem = document.getElementById("cantidadClasesHoy");
    const detalleElem = document.getElementById("detalleClasesHoy");
    const listaElem = document.getElementById("listaClasesHoy");

    cantidadElem.textContent = clases.length;
    detalleElem.textContent =
      clases.length > 0
        ? "Tenés clases programadas para hoy"
        : "No hay clases hoy";

    listaElem.innerHTML = "";

    if (clases.length > 0) {
      clases.forEach((c) => {
        const li = document.createElement("li");
        li.classList.add("mb-2", "border-bottom", "pb-1", "text-light");
        li.innerHTML = `
          <div class="d-flex justify-content-between">
            <span><i class="bi bi-clock text-secondary me-2"></i> ${c.Nombre_Clase}</span>
            <span class="text-secondary small">${c.Fecha}</span>
          </div>`;
        listaElem.appendChild(li);
      });
    }
  } catch (error) {
    console.error(" Error al cargar datos:", error);
  }
});
