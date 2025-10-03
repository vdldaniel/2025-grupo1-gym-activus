// Mock data inicial
const daysOfWeek = [
  { key: "monday", name: "Lunes" },
  { key: "tuesday", name: "Martes" },
  { key: "wednesday", name: "Miércoles" },
  { key: "thursday", name: "Jueves" },
  { key: "friday", name: "Viernes" },
  { key: "saturday", name: "Sábado" },
  { key: "sunday", name: "Domingo" },
];

let schedule = {
  monday: { open: "06:00", close: "22:00", enabled: true },
  tuesday: { open: "06:00", close: "22:00", enabled: true },
  wednesday: { open: "06:00", close: "22:00", enabled: true },
  thursday: { open: "06:00", close: "22:00", enabled: true },
  friday: { open: "06:00", close: "22:00", enabled: true },
  saturday: { open: "08:00", close: "20:00", enabled: true },
  sunday: { open: "08:00", close: "18:00", enabled: true },
};

let holidays = [
  { date: "2024-01-01", name: "Año Nuevo" },
  { date: "2024-12-25", name: "Navidad" },
];

// Renderizar horarios
function renderSchedule() {
  const container = document.getElementById("scheduleContainer");
  container.innerHTML = "";

  daysOfWeek.forEach(day => {
    const data = schedule[day.key];

    const row = document.createElement("div");
    row.className = "d-flex align-items-center gap-3 border rounded p-2";

    const label = document.createElement("div");
    label.className = "fw-bold";
    label.textContent = day.name;
    row.appendChild(label);

    const toggle = document.createElement("input");
    toggle.type = "checkbox";
    toggle.checked = data.enabled;
    toggle.className = "form-check-input";
    toggle.onchange = () => {
      schedule[day.key].enabled = toggle.checked;
      renderSchedule();
    };
    row.appendChild(toggle);

    if (data.enabled) {
      const openInput = document.createElement("input");
      openInput.type = "time";
      openInput.value = data.open;
      openInput.className = "form-control w-auto";
      openInput.onchange = (e) => (schedule[day.key].open = e.target.value);

      const closeInput = document.createElement("input");
      closeInput.type = "time";
      closeInput.value = data.close;
      closeInput.className = "form-control w-auto";
      closeInput.onchange = (e) => (schedule[day.key].close = e.target.value);

      row.appendChild(document.createTextNode(" Apertura:"));
      row.appendChild(openInput);
      row.appendChild(document.createTextNode(" Cierre:"));
      row.appendChild(closeInput);
    } else {
      const badge = document.createElement("span");
      badge.className = "badge-closed ms-2";
      badge.textContent = "Cerrado";
      row.appendChild(badge);
    }

    container.appendChild(row);
  });
}

// Renderizar feriados
function renderHolidays() {
  const list = document.getElementById("holidaysList");
  list.innerHTML = "";

  if (holidays.length === 0) {
    list.innerHTML = "<p class='text-muted'>No hay feriados configurados</p>";
    return;
  }

  holidays.forEach((h, index) => {
    const item = document.createElement("div");
    item.className = "list-group-item d-flex justify-content-between align-items-center";

    const info = document.createElement("div");
    info.innerHTML = `<strong>${h.name}</strong><br><small>${new Date(h.date).toLocaleDateString("es-ES", { weekday: "long", year: "numeric", month: "long", day: "numeric" })}</small>`;

    const removeBtn = document.createElement("button");
    removeBtn.className = "btn btn-sm btn-outline-danger";
    removeBtn.textContent = "❌";
    removeBtn.onclick = () => {
      holidays.splice(index, 1);
      renderHolidays();
    };

    item.appendChild(info);
    item.appendChild(removeBtn);
    list.appendChild(item);
  });
}

// Agregar feriado
function addHoliday() {
  const date = document.getElementById("holidayDate").value;
  const name = document.getElementById("holidayName").value;

  if (date && name) {
    holidays.push({ date, name });
    document.getElementById("holidayDate").value = "";
    document.getElementById("holidayName").value = "";
    renderHolidays();
  } else {
    alert("Completa fecha y nombre del feriado");
  }
}

// Inicializar
renderSchedule();
renderHolidays();
