<?php

namespace Model;

class Servicio extends ActiveRecord
{
  protected static $tabla = 'servicios';
  protected static $columnasDB = ['id', 'nombre', 'precio'];

  public $id;
  public $nombre;
  public $precio;

  public function __construct($args = [])
  {
    $this->id =  $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->precio =  $args['precio'] ?? '';
  }

  public function validateService()
  {
    if (!$this->nombre) {
      self::$alertas['error'][] = "EL nombre es obligatorio";
    }

    if (!is_numeric($this->precio)) {
      self::$alertas['error'][] = "EL precio es obligatorio";
    }

    return self::$alertas;
  }
}
