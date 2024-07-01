<h1 class="page-name">Nuevo Servicio</h1>
<p class="page-desc">Llena todos los campo para añadir un nuevo servicio</p>

<?php // include_once __DIR__ . "/../templates/barra.php" 
?>
<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form action="/services/create" method="POST" class="form">
  <?php include_once __DIR__ . '/formulario.php'; ?>
  <input type="submit" value="Guardar Servicio" class="boton">
</form>