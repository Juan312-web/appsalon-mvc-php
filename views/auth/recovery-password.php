<h1 class="page_name">Restablecer Contraseña</h1>
<p class="page-desc">Coloca tu nuevo password a continuacion: </p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>



<?php
if ($error) {
  return;
} ?>
<form class="form" method="POST">
  <div class="input">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Tu nuevo Password">
  </div>
  <input type="submit" class="boton" value="GUardar Nuevo Password">
</form>

<div class="actions">
  <a href="/">¿ya tienes una cuenta? Inicia Sesión</a>
  <a href="/createAccount">¿Aún no tienes una cuenta? Crear Cuenta</a>

</div>