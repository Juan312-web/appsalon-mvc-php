<h1 class="page-name">Olvide Password</h1>
<p class="page-desc">Restablece tu password escribiendo tu email a continuación</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/forget" method="POST" class="form">
  <div class="input">
    <label for="email">
      Email
    </label>
    <input type="email" name="email" id="email" placeholder="Tu Email">
  </div>
  <input type="submit" value="Enviar Instrucciones" class="boton">
</form>

<div class="actions">
  <a href="/">¿ya tienes una cuenta? Inicia Sesión</a>
  <a href="/createAccount">¿Aún no tienes una cuenta? Crear Cuenta</a>
</div>