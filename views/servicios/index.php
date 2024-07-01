<h1 class="page-name">Servicios</h1>
<p class="page-desc">Administración de servicios</p>

<?php include_once __DIR__ . "/../templates/barra.php" ?>

<ul class="services">
  <?php foreach ($servicios as $servicio) { ?>
    <li>
      <p>Nombre: <span><?php echo $servicio->nombre ?></span></p>
      <p>Precio: <span>$<?php echo $servicio->precio ?></span></p>
      <div class="actions">
        <a href="/services/update?id=<?php echo $servicio->id ?>" class="boton">Actualizar</a>
        <form action="/services/delete" method="POST">
          <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
          <input type="submit" value="Borrar" class="boton-eliminar">
        </form>
      </div>
    </li>
  <?php } ?>
</ul>