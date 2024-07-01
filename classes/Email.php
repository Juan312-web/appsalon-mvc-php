<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

  public $email;
  public $nombre;
  public $token;

  public function __construct($email, $nombre, $token)
  {

    $this->email = $email;
    $this->nombre = $nombre;
    $this->token = $token;
  }

  public function sendConfirmation()
  {
    // crear Objeto Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV['EMAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Port = $_ENV['EMAIL_PORT'];
    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_PASS'];


    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
    $mail->Subject = 'Confirma Tu Cuenta';

    // ? Set HTML
    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';

    $contenido = '<html>';
    $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has Creado tu cuenta en Appsalon, solo debes confirmarla presionando el siguiente enlace</p>";
    $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['PROJECT_URL'] . "/confirmationAccount?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
    $contenido .= '<p>Si no solicitaste esta cuenta, ignora este mensaje</p>';
    $contenido .= '</html>';

    $mail->Body = $contenido;
    $mail->send();
  }

  public function sendInstructions()
  {
    // crear Objeto Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV['EMAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Port = $_ENV['EMAIL_PORT'];
    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_PASS'];


    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
    $mail->Subject = 'Restablece Tu Password';

    // ? Set HTML
    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';

    $contenido = '<html>';
    $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer tu password, sigue el siguiente enlace para hacerlo</p>";
    $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['PROJECT_URL'] . "/recovery?token=" . $this->token . "'>Restablecer Contraseña</a></p>";
    $contenido .= '<p>Si no solicitaste esta cuenta, ignora este mensaje</p>';
    $contenido .= '</html>';

    $mail->Body = $contenido;
    $mail->send();
  }
}
