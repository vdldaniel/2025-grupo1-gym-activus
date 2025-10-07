document.addEventListener("DOMContentLoaded", () => {
  lucide.createIcons();

  const gyms = [
    {
      nombre: "Gym Fitness Club",
      direccion: "Av. Corrientes 1234",
      ciudad: "Buenos Aires",
      localidad: "Centro",
      clases: ["Crossfit", "Funcional"],
      descripcion: "Entrenamientos intensivos con profesores certificados.",
    },
    {
      nombre: "Zen Yoga Studio",
      direccion: "Calle Sucre 890",
      ciudad: "Buenos Aires",
      localidad: "Belgrano",
      clases: ["Yoga"],
      descripcion: "Clases de yoga para todos los niveles. Ambiente relajado.",
    },
    {
      nombre: "Cyclo Center",
      direccion: "Av. Santa Fe 3450",
      ciudad: "Buenos Aires",
      localidad: "Palermo",
      clases: ["Spinning"],
      descripcion: "Entrená al ritmo de la música con bikes de última generación.",
    },
    {
      nombre: "Move Fit",
      direccion: "Av. 7 1200",
      ciudad: "La Plata",
      localidad: "Centro",
      clases: ["Funcional", "Crossfit"],
      descripcion: "Rutinas variadas, enfoque en fuerza y coordinación.",
    },
    {
      nombre: "Rosario Fit Zone",
      direccion: "Bv. Oroño 2450",
      ciudad: "Rosario",
      localidad: "Pichincha",
      clases: ["Yoga", "Funcional"],
      descripcion: "Entrenamientos personalizados y espacios modernos.",
    },
  ];

  const gymList = document.getElementById("gymList");
  const filterClase = document.getElementById("filterClase");
  const filterCiudad = document.getElementById("filterCiudad");
  const filterLocalidad = document.getElementById("filterLocalidad");
  const filterDireccion = document.getElementById("filterDireccion");
  const btnFiltrar = document.getElementById("btnFiltrar");

  function renderGyms(lista) {
    gymList.innerHTML = "";

    if (lista.length === 0) {
      gymList.innerHTML = `<p class="text-center text-gray">No se encontraron gimnasios que coincidan con los filtros.</p>`;
      return;
    }

    lista.forEach((gym) => {
      const card = document.createElement("div");
      card.classList.add("col-md-6", "col-lg-4");

      card.innerHTML = `
        <div class="card bg-card p-3 h-100">
          <h5 class="text-white mb-2"><i data-lucide="dumbbell" class="me-1"></i> ${gym.nombre}</h5>
          <p class="text-gray mb-1"><i data-lucide="map-pin" class="me-1"></i> ${gym.direccion}, ${gym.localidad} - ${gym.ciudad}</p>
          <p class="text-gray mb-1"><i data-lucide="clock" class="me-1"></i> Clases: ${gym.clases.join(", ")}</p>
          <p class="text-gray small mb-3">${gym.descripcion}</p>
          <div class="text-end">
            <a href="../administrativo/info-gym.html" class="btn btn-outline-primary btn-sm btn-custom">
                        <i data-lucide="info" class="me-1"></i> Ver detalles
                    </a>
          </div>
        </div>
      `;
      gymList.appendChild(card);
    });

    lucide.createIcons();
  }

  function filtrarGyms() {
    const clase = filterClase.value.trim().toLowerCase();
    const ciudad = filterCiudad.value.trim().toLowerCase();
    const localidad = filterLocalidad.value.trim().toLowerCase();
    const direccion = filterDireccion.value.trim().toLowerCase();

    const filtrados = gyms.filter((gym) => {
      const coincideClase = !clase || gym.clases.some((c) => c.toLowerCase() === clase);
      const coincideCiudad = !ciudad || gym.ciudad.toLowerCase().includes(ciudad);
      const coincideLocalidad = !localidad || gym.localidad.toLowerCase().includes(localidad);
      const coincideDireccion = !direccion || gym.direccion.toLowerCase().includes(direccion);
      return coincideClase && coincideCiudad && coincideLocalidad && coincideDireccion;
    });

    renderGyms(filtrados);
  }

  btnFiltrar.addEventListener("click", filtrarGyms);

  renderGyms(gyms);
});
