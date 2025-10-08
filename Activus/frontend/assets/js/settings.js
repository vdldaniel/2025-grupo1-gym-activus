const daysOfWeek = [
  { key: "monday", name: "Lunes" },
  { key: "tuesday", name: "Martes" },
  { key: "wednesday", name: "Miércoles" },
  { key: "thursday", name: "Jueves" },
  { key: "friday", name: "Viernes" },
  { key: "saturday", name: "Sábado" },
  { key: "sunday", name: "Domingo" },
];

let holidays = [];

function renderSchedule() {
  const container = document.getElementById("scheduleContainer");
  container.innerHTML = "";
  daysOfWeek.forEach(day => {
    const div = document.createElement("div");
    div.className = "d-flex align-items-center gap-3 mb-2 p-2 border rounded";

    div.innerHTML = `
      <div class="text-white" style="width:100px;">${day.name}</div>
      <input type="time" class="form-control dark-input w-auto" value="06:00">
      <span class="text-white">a</span>
      <input type="time" class="form-control dark-input w-auto" value="22:00">
    `;
    container.appendChild(div);
  });
}

function addHoliday() {
  const date = document.getElementById("holidayDate").value;
  const name = document.getElementById("holidayName").value;

  if (!date || !name) return;

  holidays.push({ date, name });
  renderHolidays();
  document.getElementById("holidayDate").value = "";
  document.getElementById("holidayName").value = "";
}

function removeHoliday(index) {
  holidays.splice(index, 1);
  renderHolidays();
}

function renderHolidays() {
  const list = document.getElementById("holidaysList");
  list.innerHTML = "";
  if (holidays.length === 0) {
    list.innerHTML = `<p class="text-gray">No hay feriados configurados</p>`;
    return;
  }
  holidays.forEach((holiday, index) => {
    const div = document.createElement("div");
    div.className = "d-flex justify-content-between align-items-center p-2 border rounded mb-2";
    div.innerHTML = `
      <div>
        <p class="text-white mb-0">${holiday.name}</p>
        <small class="text-gray">${new Date(holiday.date).toLocaleDateString("es-ES", {
          weekday: "long", year: "numeric", month: "long", day: "numeric"
        })}</small>
      </div>
      <button class="btn btn-sm btn-outline-light" onclick="removeHoliday(${index})">X</button>
    `;
    list.appendChild(div);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  renderSchedule();
  renderHolidays();
});

