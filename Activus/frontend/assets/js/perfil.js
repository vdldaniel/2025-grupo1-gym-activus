document.addEventListener("DOMContentLoaded", () => {
  lucide.createIcons();

  const editBtn = document.getElementById("editProfileBtn");
  editBtn.addEventListener("click", () => {
    // Redirige a la versión editable del perfil
    window.location.href = "perfil-admin.html";
  });
});
