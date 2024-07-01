<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
  //? iniciar sesion
  public static function index(Router $router)
  {
    session_start();

    if ($_SESSION['login']) {
      if ($_SESSION['admin'] === "1") {
        header('location: /admin');
      }

      header('location: /cita');
    }

    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new Usuario($_POST);
      $alertas = $auth->validateLogin();

      if (empty($alertas)) {
        $usuario = Usuario::where('email', $auth->email);

        if (!$usuario) {
          Usuario::setAlerta('error', 'El usuario no existe');
        } else {


          if ($usuario->checkAuthenticatedUser($auth->password)) {
            // ? Autenticar Usuario
            // iniciar sesion
            session_start();

            // Agregar Datos
            $_SESSION['id'] =  $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
            $_SESSION['email'] =  $usuario->email;
            $_SESSION['login'] =  true;

            // ? Redireccion

            if ($usuario->admin === '1') {
              $_SESSION['admin'] = $usuario->admin ?? null;
              header('location: /admin');
            } else {
              header('location: /cita');
            }
          }
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/login', [
      'alertas' => $alertas
    ]);
  }

  //? cerrar sesion
  public static function logout()
  {
    session_start();
    $_SESSION = [];

    header('location: /');
  }

  //? olvidaste contraseña
  public static function forget(Router $router)
  {
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD']  === 'POST') {
      $auth = new Usuario($_POST);
      $alertas = $auth->validateForgetEmail();

      if (empty($alertas)) {
        $usuario = Usuario::where('email', $auth->email);

        if ($usuario && $usuario->confirmado === "1") {

          // ? Generar token de unico uso
          $usuario->createToken();

          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $usuario->guardar();

          // ? ENviar Email
          $email->sendInstructions();
          Usuario::setAlerta('exito', "Revisa tu email");
        } else {
          Usuario::setAlerta('error', "El usuario no existe o no esta confirmado");
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/forget-password', ["alertas" => $alertas]);
  }

  //? recuperar
  public static function recovery(Router $router)
  {
    $alertas = [];
    $error = false;

    $token = s($_GET['token']);

    // ? Buscar Usuario por token
    $usuario = Usuario::where('token', $token);

    if (empty($usuario)) {
      Usuario::setAlerta('error', "token no valido");
      $error = true;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // ? Leer nuevo password y guardarlo
      $password = new Usuario($_POST);
      $alertas = $password->validateNewPassword();

      if (empty($alertas)) {
        $usuario->password = null;
        $usuario->password = $password->password;

        $usuario->hashPassword();
        $usuario->token = null;

        $resultado = $usuario->guardar();

        if ($resultado) {
          header('location: /');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/recovery-password', ["alertas" => $alertas, "error" => $error]);
  }

  //? crear cuenta
  public static function createAccount(Router $router)
  {
    $usuario = new Usuario;
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $usuario->sincronizar($_POST);
      $alertas = $usuario->validateNewAccount();

      // ? Revisar que alertas este vacio
      if (empty($alertas)) {
        // ? verificar que el usuario no este registrado
        $resultado = $usuario->existUser();
        if ($resultado->num_rows) {
          $alertas = Usuario::getAlertas();
        } else {
          // ? Hash Password
          $usuario->hashPassword();

          // ? Generar un Token Unico
          $usuario->createToken();

          // ? Enviar email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

          $email->sendConfirmation();

          // ? Crear usuario
          $resultado = $usuario->guardar();

          if ($resultado) {
            header('location: /message');
          }

          debuguear($resultado);
        }
      }
    }

    $router->render('auth/createAccount', ['usuario' => $usuario, "alertas" => $alertas]);
  }

  public static function message(Router $router)
  {
    $router->render('auth/message');
  }

  public static function confirmationAccount(Router $router)
  {
    $alertas = [];
    $token = s($_GET['token']);

    $usuario = Usuario::where('token', $token);

    if (empty($usuario)) {
      //  modificar usuario confirmado
      Usuario::setAlerta('error', 'Token no Valido');
    } else {
      $usuario->confirmado = 1;
      $usuario->token = null;

      $usuario->guardar();

      Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/confirmationaccount', [
      'alertas' => $alertas
    ]);
  }
}
