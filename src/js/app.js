let step = 1;
const initialStep = 1;
const endStep = 3;

const cita = {
  id: '',
  nombre: '',
  fecha: '',
  hora: '',
  servicios: [],
};

document.addEventListener('DOMContentLoaded', function () {
  initApp();
});

function initApp() {
  showSection(); // * Muestra y oculta las seccione
  tabs(); // * Cambia la seccion cuando se presionan los tabs
  buttonPagination(); // * Agrega o quita los botones del paginador
  nextPage();
  previousPage();
  consultAPI(); // * Consulta la API en el backend de PHP
  nameClient(); // * Asigna nombre de cliente al arreglo cita
  idClient(); // * Asigna id de cliente al arreglo cita
  selectedDate(); // * Asigna fecha al arreglo cita
  selectedHour(); // * Asigna hora al arreglo cita
  showSummary(); // * Muestra resumen de la cita
}

function showSection() {
  // ? Ocultar seccion anterior
  const oldSection = document.querySelector('.show');
  if (oldSection) {
    oldSection.classList.remove('show');
  }

  // ? Seleccionar seccion con el paso...
  const stepSelector = `#step-${step}`;
  const section = document.querySelector(stepSelector);
  section.classList.add('show');

  // ? Resalta el tab actual
  const oldTab = document.querySelector('.current');
  if (oldTab) {
    oldTab.classList.remove('current');
  }

  const tabSelector = `[data-step="${step}"]`;
  const tab = document.querySelector(tabSelector);

  tab.classList.add('current');
}

function tabs() {
  const buttons = document.querySelectorAll('.tabs button');
  buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
      let currentStep = parseInt(e.target.dataset.step);
      step = currentStep;
      showSection();
      buttonPagination();
    });
  });
}

function buttonPagination() {
  const previousPage = document.querySelector('#previuos');
  const nextPage = document.querySelector('#next');

  if (step === 1) {
    previousPage.classList.add('hide');
    nextPage.classList.remove('hide');
  } else if (step === 3) {
    previousPage.classList.remove('hide');
    nextPage.classList.add('hide');
    showSummary();
  } else {
    previousPage.classList.remove('hide');
    nextPage.classList.remove('hide');
  }

  showSection();
}

function previousPage() {
  const previousPage = document.querySelector('#previuos');
  previousPage.addEventListener('click', () => {
    if (step <= initialStep) return;
    step--;
    buttonPagination();
  });
}

function nextPage() {
  const nextPage = document.querySelector('#next');
  nextPage.addEventListener('click', () => {
    if (step >= endStep) return;
    step++;
    buttonPagination();
  });
}

async function consultAPI() {
  try {
    const url = `${location.origin}/api/servicios`;
    const resultado = await fetch(url);
    const servicios = await resultado.json();

    showServices(servicios);
  } catch (error) {}
}

function showServices(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement('P');
    nombreServicio.classList.add('name-service');
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement('P');
    precioServicio.classList.add('price-service');
    precioServicio.textContent = `$${precio}`;

    const serviceDiv = document.createElement('DIV');
    serviceDiv.classList.add('service');
    serviceDiv.dataset.idServicio = id;

    serviceDiv.appendChild(nombreServicio);
    serviceDiv.appendChild(precioServicio);

    serviceDiv.onclick = () => {
      selectedService(servicio);
    };

    document.querySelector('#services').appendChild(serviceDiv);
  });
}

function selectedService(servicio) {
  const { servicios } = cita;
  const { id } = servicio;
  const divService = document.querySelector(`[data-id-servicio="${id}"]`);

  // ? Comprobar si servicio existe
  if (servicios.some((agregado) => agregado.id === id)) {
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divService.classList.remove('selected');
  } else {
    cita.servicios = [...servicios, servicio];
    divService.classList.add('selected');
  }
}

function nameClient() {
  cita.nombre = document.querySelector('#nombre').value;
}

function idClient() {
  cita.id = document.querySelector('#id').value;
}

function selectedDate() {
  const inputFecha = document.querySelector('#fecha');
  inputFecha.addEventListener('input', (e) => {
    const dia = new Date(e.target.value).getUTCDay();

    if ([6, 0].includes(dia)) {
      e.target.value = '';
      showAlert('Fines de Semana no permitidos', 'error', '.form');
    } else {
      cita.fecha = e.target.value;
    }
  });
}

function selectedHour() {
  const inputHora = document.querySelector('#hora');
  inputHora.addEventListener('input', (e) => {
    const horaCita = e.target.value;
    const hora = horaCita.split(':')[0];

    if (hora < 10 || hora > 18) {
      e.target.value = '';
      showAlert('Horario solo entre 11:00 y 16:00', 'error', '.form');
    } else {
      cita.hora = e.target.value;
      console.log(cita);
    }
  });
}

function showAlert(mensaje, tipo, elemento, desaparece = true) {
  // * Previene la repeticion de alertas
  const alertaPrevia = document.querySelector('.alerta');

  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  // * Scripting de alerta
  const alerta = document.createElement('DIV');
  alerta.textContent = mensaje;
  alerta.classList.add('alerta');
  alerta.classList.add(tipo);

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  // * Eliminar Alerta
  if (desaparece) {
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function showSummary() {
  const { nombre, fecha, hora, servicios } = cita;
  const containerSummary = document.querySelector('.container-summary');

  // ? Limpiar contenido de resumen
  while (containerSummary.firstChild) {
    containerSummary.removeChild(containerSummary.firstChild);
  }

  if (Object.values(cita).includes('') || cita.servicios.length < 1) {
    showAlert(
      'Faltan Datos de servicios, Fecha u Hora',
      'error',
      '.container-summary',
      false
    );
    return;
  }

  // ? Heading para servicios
  const tituloServicios = document.createElement('H3');
  tituloServicios.textContent = 'Resumen de Servicios';

  containerSummary.appendChild(tituloServicios);

  // ? Iterar y Mostrar servicios
  servicios.forEach((servicio) => {
    const { id, precio, nombre } = servicio;
    const contenedorServicio = document.createElement('DIV');
    contenedorServicio.classList.add('container-service');

    const textoServicio = document.createElement('P');
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement('P');
    precioServicio.innerHTML = `<span>Precio: </span> $${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);

    containerSummary.appendChild(contenedorServicio);
  });

  // ? Titulo de la cita
  const tituloCita = document.createElement('H3');
  tituloCita.textContent = 'Resumen de Cita';

  containerSummary.appendChild(tituloCita);

  // ? Scripting al div de resumen
  const nombreCliente = document.createElement('P');
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

  const fechaCita = document.createElement('P');
  fechaCita.innerHTML = `<span>Fecha:</span> ${fecha}`;

  // ? Formatear fecha español
  const fechaObj = new Date(fecha);

  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const anio = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(anio, mes, dia));

  const opcionesFormato = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };
  const fechaFormateada = fechaUTC.toLocaleDateString('es-CO', opcionesFormato);

  console.log(fechaFormateada);

  const horaCita = document.createElement('P');
  horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

  containerSummary.appendChild(nombreCliente);
  containerSummary.appendChild(fechaCita);
  containerSummary.appendChild(horaCita);

  // ? Boton crear cita
  const botonReservar = document.createElement('BUTTON');
  botonReservar.classList.add('boton');
  botonReservar.textContent = 'Reservar Cita';
  botonReservar.onclick = reserveAppointment;
  containerSummary.appendChild(botonReservar);
}

async function reserveAppointment() {
  const { id, fecha, hora, servicios } = cita;
  const idServicios = servicios.map((servicio) => servicio.id);

  const datos = new FormData();

  datos.append('fecha', fecha);
  datos.append('hora', hora);
  datos.append('usuarioId', id);

  datos.append('servicios', idServicios);

  try {
    // ? Peticion a API
    const url = `${location.origin}/api/citas`;

    const respuesta = await fetch(url, {
      method: 'POST',
      body: datos,
    });

    const resultado = await respuesta.json();

    if (resultado.resultado) {
      Swal.fire({
        icon: 'success',
        title: 'Cita Creada',
        text: 'Tu Cita Fue Creada Con Exito!',
      }).then(() => {
        window.location.reload();
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Algo a salido mal al guardar tu cita!',
    });
  }
}
