<h1 class="page-name">Login</h1>
<p class="page-desc">Login with your data</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/" class="form" method="POST">
  <div class="input">
    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Tu Email" name="email">
  </div>
  <div class="input">
    <label for="password">Password</label>
    <input type="password" id=" password" placeholder="Tu password" name="password">
  </div>
  <input class="boton" type="submit" value="Iniciar Sesión">
</form>

<div class="actions">
  <a href="/createAccount">¿Aún no tienes una cuenta? Crear Cuenta</a>
  <a href="/forget">¿Olvidaste tu password?</a>
</div>