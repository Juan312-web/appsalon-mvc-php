<h1 class="page-name">Actualizar Servicio</h1>
<p class="page-desc">Modifica los valores del formulario</p>

<?php // include_once __DIR__ . "/../templates/barra.php" 
?>
<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form method="POST" class="form">
  <?php include_once __DIR__ . '/formulario.php'; ?>
  <input type="submit" value="Actualizar" class="boton">
</form>