document.addEventListener("DOMContentLoaded", async () => {
  try {
    const resp = await fetch("/inicio-administrador/datos");
    const json = await resp.json();

    if (!json.success) throw new Error(json.error || "Error al cargar datos");

    const d = json.data;
    document.getElementById("totalUsuarios").textContent = d.totalUsuarios ?? "-";
    document.getElementById("descripcionUsuarios").textContent = d.descripcion ?? "-";
  } catch (e) {
    console.error("Error al cargar datos del admin:", e);
  }
});
