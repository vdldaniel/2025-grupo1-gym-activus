document.addEventListener("DOMContentLoaded", () => {
  // Datos simulados cargados por el administrativo (podrían venir de una API)
  const gymData = {
    name: "Gym Fitness Club",
    location: "Av. Corrientes 1234, Buenos Aires, Argentina",
    coordinates: [-34.6037, -58.3816], // Buenos Aires
    schedule: {
      Lunes: "8:00 - 21:00",
      Martes: "8:00 - 21:00",
      Miércoles: "8:00 - 21:00",
      Jueves: "8:00 - 21:00",
      Viernes: "8:00 - 21:00",
      Sábado: "9:00 - 18:00",
      Domingo: "Cerrado"
    },
    holidays: [
      { date: "9 de Julio", name: "Día de la Independencia" },
      { date: "25 de Diciembre", name: "Navidad" }
    ]
  };

  // Mostrar datos
  document.getElementById("gymName").textContent = gymData.name;
  document.getElementById("gymLocation").textContent = gymData.location;

  const scheduleList = document.getElementById("scheduleList");
  for (const [day, hours] of Object.entries(gymData.schedule)) {
    const li = document.createElement("li");
    li.textContent = `${day}: ${hours}`;
    scheduleList.appendChild(li);
  }

  const holidayList = document.getElementById("holidayList");
  gymData.holidays.forEach(h => {
    const li = document.createElement("li");
    li.textContent = `${h.date} – ${h.name}`;
    holidayList.appendChild(li);
  });

  // Inicializar mapa con Leaflet
  const map = L.map('map').setView(gymData.coordinates, 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
  }).addTo(map);

  L.marker(gymData.coordinates).addTo(map)
    .bindPopup(`<b>${gymData.name}</b><br>${gymData.location}`)
    .openPopup();
});
