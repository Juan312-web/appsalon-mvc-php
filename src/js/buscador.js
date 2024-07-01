document.addEventListener('DOMContentLoaded', function () {
  initApp();
});

function initApp() {
  searchOfDate(); // * Buscar por fecha
}

function searchOfDate() {
  const fechaInput = document.querySelector('#date');
  fechaInput.addEventListener('input', (e) => {
    const fechaSeleccionada = e.target.value;
    window.location = `?fecha=${fechaSeleccionada}`;
  });
}
