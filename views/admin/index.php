<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h1 class="page-name">Panel de Administracion</h1>

<h2>Buscar Citas</h2>

<div class="search">
  <form class="form">
    <div class="input">
      <label for="fecha">
        Fecha:
      </label>
      <input type="date" name="fecha" id="date" value="<?php echo $fecha; ?>">
    </div>
  </form>
</div>

<?php
if (count($citas) === 0) {
  echo "<h3>No hay Citas en esta Fecha</h3>";
}
?>

<div class="cita-admin">
  <ul class="citas">
    <?php
    $idCita = 0;
    foreach ($citas as $key => $cita) {
      if ($idCita !== $cita->id) {
        $total = 0;
    ?>
        <li>
          <p>ID: <span><?php echo $cita->id; ?></span></p>
          <p>Hora: <span><?php echo $cita->hora; ?></span></p>
          <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
          <p>Email: <span><?php echo $cita->email; ?></span></p>
          <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
          <h1>Servicio</h1>

        <?php $idCita = $cita->id;
      } // Fin de Condicional  

      $total += $cita->precio;
        ?>

        <p class="servicio"><?php echo $cita->servicio . " - $" . $cita->precio; ?></p>

        <?php
        $actual = $cita->id;
        $proximo = $citas[$key + 1]->id ?? 0;

        if (esUltimo($actual, $proximo)) {
        ?>
          <p class="total">Total: <span>$ <?php echo $total ?></span></p>
          <form action="/api/delete" method="POST">
            <input type="hidden" name="id" value="<?php echo $cita->id ?>">
            <input type="submit" value="Eliminar" class="boton-eliminar">
          </form>
      <?php }
      } // Fin de Bucle 
      ?>

  </ul>
</div>

<?php

$script = "<script src='build/js/buscador.js'></script>;"
?>