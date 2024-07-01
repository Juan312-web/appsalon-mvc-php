<h1 class="page-name">Crear Cuenta</h1>
<p class="page-desc">Llena el formulario para crear una cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/createAccount" class="form" method="POST">
  <div class="input">
    <label for="nombre">Nombre: </label>
    <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre) ?>">
  </div>
  <div class="input">
    <label for="apellido">Apellido: </label>
    <input type="text" id="apellido" name="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido) ?>">
  </div>
  <div class="input">
    <label for="telefono">Telefono: </label>
    <input type="tel" id="telefono" name="telefono" placeholder="Tu Telefono" value="<?php echo s($usuario->telefono) ?>">
  </div>
  <div class="input">
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" placeholder="Tu Email" value="<?php echo s($usuario->email) ?>">
  </div>
  <div class="input">
    <label for="password">Password: </label>
    <input type="password" id="password" name="password" placeholder="Tu Password" value="">
  </div>

  <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="actions">
  <a href="/">¿ya tienes una cuenta? Inicia Sesión</a>
  <a href="/forget">¿Olvidaste tu password?</a>
</div>