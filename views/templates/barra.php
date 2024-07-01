<div class="barra">
  <p>Hola, <?php echo $nombre ?? ''; ?></p>
  <a href="/logout" class="boton">Cerrar Sesion</a>
</div>

<?php if (isset($_SESSION['admin'])) { ?>
  <div class="barra-servicios">
    <a href="/admin" class="boton">Ver Citas</a>
    <a href="/services" class="boton">Ver Servicios</a>
    <a href="/services/create" class="boton">Nuevo Servicio</a>
  </div>

<?php } ?>