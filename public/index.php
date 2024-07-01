<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CItaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

// RUTAS
$router = new Router();

// ? Iniciar sesion -----------------------------------------------------------------
$router->get('/', [LoginController::class, 'index']);
$router->post('/', [LoginController::class, 'index']);

// ? Cerrar sesion
$router->get('/logout', [LoginController::class, 'logout']);

// ? recuperar password
$router->get('/forget', [LoginController::class, 'forget']);
$router->post('/forget', [LoginController::class, 'forget']);
$router->get('/recovery', [LoginController::class, 'recovery']);
$router->post('/recovery', [LoginController::class, 'recovery']);
// ? --------------------------------------------------------------------------------


// ? Crear Cuenta -------------------------------------------------------------------
$router->get('/createAccount', [LoginController::class, 'createAccount']);
$router->post('/createAccount', [LoginController::class, 'createAccount']);
// ? --------------------------------------------------------------------------------

// ? Confirmar CUenta -------------------------------------------------------------------
$router->get('/confirmationAccount', [LoginController::class, 'confirmationAccount']);
$router->get('/message', [LoginController::class, 'message']);
// ? --------------------------------------------------------------------------------


// ? Area Privada
$router->get('/cita', [CItaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);
// ? --------------------------------------------------------------------------------

// ? API de Citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

// ? --------------------------------------------------------------------------------


// ? Administrar Servicios
$router->get('/services', [ServicioController::class, 'index']);

$router->get('/services/create', [ServicioController::class, 'create']);
$router->post('/services/create', [ServicioController::class, 'create']);

$router->get('/services/update', [ServicioController::class, 'update']);
$router->post('/services/update', [ServicioController::class, 'update']);

$router->post('/services/delete', [ServicioController::class, 'delete']);
// ? --------------------------------------------------------------------------------
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->checkRoute();
