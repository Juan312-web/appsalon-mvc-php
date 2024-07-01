<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h1 class="page-name">Crear Cita</h1>
<p class="page-desc">Elige tus servicios y ingresa tus datos</p>

<div id="app">
  <div class="tabs">
    <button class="current" type="button" data-step="1">Servicios</button>
    <button type="button" data-step="2">Informacion Cita</button>
    <button type="button" data-step="3">Resumen</button>
  </div>
  <!-- Pasos -->
  <div id="step-1" class="section">
    <h2>Servicios</h2>
    <p class="text-center">Elige tus servicios a continuacion</p>
    <div id="services" class="list-services"></div>
  </div>
  <div id="step-2" class="section">
    <h2>Tus Datos y Cita </h2>
    <p class="text-center">Coloca tus datos y fecha de tu cita</p>
    <form class="form">
      <div class="input">
        <label for="nombre">Nombre</label>
        <input type="text" disabled id="nombre" placeholder="Tu nombre" value="<?php echo $nombre ?>">
      </div>
      <div class="input">
        <label for="fecha">Fecha</label>
        <input min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>" type="date" id="fecha">
      </div>
      <div class="input">
        <label for="hora">Hora</label>
        <input type="time" id="hora">
      </div>
      <input type="hidden" id="id" value="<?php echo $_SESSION['id'] ?>">

    </form>
  </div>
  <div id="step-3" class="section container-summary">
    <h2>Resumen</h2>
    <p class="text-center">Verifica que la informacion sea correcta</p>
  </div>
  <!-- / Pasos -->

  <div class="pagination">
    <button id="previuos" class="boton">&laquo; Anterior</button>
    <button id="next" class="boton">Siguiente &raquo;</button>
  </div>
</div>

<?php $script = "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>;
  <script src='build/js/app.js'></script>;
"; ?>