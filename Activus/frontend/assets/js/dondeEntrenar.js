


const daysOfWeek = [
  { key: "monday", name: "Lunes" },
  { key: "tuesday", name: "Martes" },
  { key: "wednesday", name: "Miércoles" },
  { key: "thursday", name: "Jueves" },
  { key: "friday", name: "Viernes" },
  { key: "saturday", name: "Sábado" },
  { key: "sunday", name: "Domingo" },
];



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

function renderSchedule1() {
  const container = document.getElementById("scheduleContainer1");
  container.innerHTML = "";
  daysOfWeek.forEach(day => {
    const div = document.createElement("div");
    div.className = "d-flex align-items-center gap-3 mb-2 p-2 border rounded";

    div.innerHTML = `
      <div class="text-white" style="width:100px;">${day.name}</div>
      <p class="form-control dark-input w-auto">06:00</p>
      <span class="text-white">a</span>
      <p class="form-control dark-input w-auto">22:00</p>
    `;
    container.appendChild(div);
  });
}


document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("scheduleContainer")) {
    renderSchedule();
  }

  if (document.getElementById("scheduleContainer1")) {
    renderSchedule1();
  }
});