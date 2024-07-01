<?php

namespace Model;

class Usuario extends ActiveRecord
{
  protected static $tabla = 'usuarios';
  protected static $columnasDB = [
    'id',
    'admin',
    'telefono',
    'email',
    'apellido',
    'nombre',
    'confirmado',
    'token',
    'password'
  ];

  public $id;
  public $admin;
  public $telefono;
  public $email;
  public $apellido;
  public $nombre;
  public $confirmado;
  public $token;
  public $password;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->telefono = $args['telefono'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->nombre = $args['nombre'] ?? '';
    $this->token = $args['token'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirmado = $args['confirmado'] ?? 0;
    $this->admin = $args['admin'] ?? 0;
  }

  // ? Mensajes de Validacion para Creacion de cuenta
  public function  validateNewAccount()
  {
    if (!$this->nombre) {
      self::$alertas['error'][] = "El Nombre es obligatorio";
    }

    if (!$this->apellido) {
      self::$alertas['error'][] = "El Apellido es obligatorio";
    }

    if (!$this->telefono) {
      self::$alertas['error'][] = "El Telefono es obligatorio";
    }

    if (!$this->email) {
      self::$alertas['error'][] = "El Email  es obligatorio";
    }

    if (!$this->password || strlen($this->password) < 6) {
      self::$alertas['error'][] = "El password debe ser almenos de 6 caracteres";
    }

    return self::$alertas;
  }

  // ? Mensajes de Validacion para Iniciar sesion
  public function validateLogin()
  {
    if (!$this->email) {
      self::$alertas['error'][] = "El Email es obligatorio";
    }


    if (!$this->password) {
      self::$alertas['error'][] = "El Password es obligatorio";
    }

    return self::$alertas;
  }

  // ? Mensajes de Validacion para Olvide Contraseña
  public function validateForgetEmail()
  {
    if (!$this->email) {
      self::$alertas['error'][] = "El Email  es obligatorio";
    }

    return self::$alertas;
  }

  public function validateNewPassword()
  {
    if (!$this->password || strlen($this->password) < 6) {
      self::$alertas['error'][] = "El password debe ser almenos de 6 caracteres";
    }
    return self::$alertas;
  }

  // ? Revisa si el usuuario ya existe
  public function existUser()
  {
    $query = "SELECT * FROM " . self::$tabla  . " WHERE email = '" . $this->email . "' LIMIT 1";
    $resultado = self::$db->query($query);

    if ($resultado->num_rows) {
      self::$alertas['error'][] = "EL usuario ya esta registrado";
    }

    return $resultado;
  }

  public function hashPassword()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function createToken()
  {
    $this->token = uniqid();
  }

  public function checkAuthenticatedUser($password)
  {
    $resultado = password_verify($password, $this->password);
    if (!$resultado || !$this->confirmado) {
      self::$alertas['error'][] = 'Password incorrecto o cuenta no confirmada';
    } else {
      return true;
    }
  }
}
