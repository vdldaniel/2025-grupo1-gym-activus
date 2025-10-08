// profile.js
document.addEventListener("DOMContentLoaded", () => {
  lucide.createIcons();
});

document.addEventListener("DOMContentLoaded", () => {
  lucide.createIcons();

  // Inicializar modales Bootstrap
  const modalCorreo = new bootstrap.Modal(document.getElementById("modalCorreo"));
  const modalClave = new bootstrap.Modal(document.getElementById("modalClave"));

  // Botones del panel lateral
  const btnCorreo = document.querySelector(".custom-btn:nth-child(1)");
  const btnClave = document.querySelector(".custom-btn:nth-child(2)");

  btnCorreo.addEventListener("click", () => modalCorreo.show());
  btnClave.addEventListener("click", () => modalClave.show());

  // --- Validación cambio de correo ---
  document.getElementById("formCorreo").addEventListener("submit", (e) => {
    e.preventDefault();
    const nuevoCorreo = document.getElementById("nuevoCorreo").value;
    const claveActual = document.getElementById("claveActualCorreo").value;

    if (claveActual.length < 3) {
      alert("Debes ingresar tu contraseña actual para validar el cambio.");
      return;
    }

    alert(`Correo actualizado exitosamente a: ${nuevoCorreo}`);
    modalCorreo.hide();
    e.target.reset();
  });

  // --- Validación cambio de contraseña ---
  document.getElementById("formClave").addEventListener("submit", (e) => {
    e.preventDefault();
    const actual = document.getElementById("claveActual").value;
    const nueva = document.getElementById("nuevaClave").value;
    const confirmar = document.getElementById("confirmarClave").value;

    if (actual.length < 3) {
      alert("Debes ingresar tu contraseña actual para continuar.");
      return;
    }

    if (nueva !== confirmar) {
      alert("Las contraseñas nuevas no coinciden.");
      return;
    }

    alert("Contraseña actualizada exitosamente.");
    modalClave.hide();
    e.target.reset();
  });
});
