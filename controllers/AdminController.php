<?php

namespace Controllers;

use Model\AdminCIta;
use MVC\Router;

class AdminController
{
  public static function index(Router $router)
  {
    session_start();

    isAdmin();

    $fecha = $_GET['fecha'] ?? date('Y-m-d');
    $fechas = explode('-', $fecha);

    if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
      header("location: /404");
    }

    // ? Consultar la base de datos
    $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
    $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
    $consulta .= " FROM citas  ";
    $consulta .= " LEFT OUTER JOIN usuarios ";
    $consulta .= " ON citas.usuarioId=usuarios.id  ";
    $consulta .= " LEFT OUTER JOIN citaServicios ";
    $consulta .= " ON citaservicios.citaId=citas.id ";
    $consulta .= " LEFT OUTER JOIN servicios ";
    $consulta .= " ON servicios.id=citaservicios.servicioId ";
    $consulta .= " WHERE fecha =  '{$fecha}' ";

    $cita = AdminCIta::SQL($consulta);

    $router->render('admin/index', [
      "nombre" => $_SESSION['nombre'],
      "citas" => $cita,
      "fecha" => $fecha
    ]);
  }
}
