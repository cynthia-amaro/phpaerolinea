<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
use App\Controllers\AsignacionController;
use App\Controllers\TripulanteController;
use App\Controllers\PasajeroController;
use App\Controllers\AvionController;
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\VueloController;
use App\Controllers\ReservaController;


require_once __DIR__ . '/../config/config.php';

spl_autoload_register(function (string $clase): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    if (strpos($clase, $prefix) !== 0) {
        return;
    }

    $relativeClass = substr($clase, strlen($prefix));

    $file = $baseDir
        . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass)
        . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new Router();
$router->get('/asignaciones', [AsignacionController::class, 'index']);
$router->get('/asignaciones/crear', [AsignacionController::class, 'crear']);
$router->post('/asignaciones/guardar', [AsignacionController::class, 'guardar']);
$router->post('/asignaciones/eliminar', [AsignacionController::class, 'eliminar']);
$router->get('/tripulantes/vuelos', [AsignacionController::class, 'vuelosDeTripulante']);
$router->get('/tripulantes', [TripulanteController::class, 'index']);
$router->get('/tripulantes/crear', [TripulanteController::class, 'crear']);
$router->post('/tripulantes/guardar', [TripulanteController::class, 'guardar']);
$router->get('/tripulantes/editar', [TripulanteController::class, 'editar']);
$router->post('/tripulantes/actualizar', [TripulanteController::class, 'actualizar']);
$router->post('/tripulantes/eliminar', [TripulanteController::class, 'eliminar']);
$router->get('/pasajeros', [PasajeroController::class, 'index']);
$router->get('/pasajeros/crear', [PasajeroController::class, 'crear']);
$router->post('/pasajeros/guardar', [PasajeroController::class, 'guardar']);
$router->get('/pasajeros/editar', [PasajeroController::class, 'editar']);
$router->post('/pasajeros/actualizar', [PasajeroController::class, 'actualizar']);
$router->post('/pasajeros/eliminar', [PasajeroController::class, 'eliminar']);
$router->get('/vuelos/crear', [VueloController::class, 'crear']);
$router->post('/vuelos/guardar', [VueloController::class, 'guardar']);
$router->get('/vuelos/editar', [VueloController::class, 'editar']);
$router->post('/vuelos/actualizar', [VueloController::class, 'actualizar']);
$router->post('/vuelos/eliminar', [VueloController::class, 'eliminar']);
$router->get('/aviones', [AvionController::class, 'index']);
$router->get('/aviones/crear', [AvionController::class, 'crear']);
$router->post('/aviones/guardar', [AvionController::class, 'guardar']);
$router->get('/aviones/editar', [AvionController::class, 'editar']);
$router->post('/aviones/actualizar', [AvionController::class, 'actualizar']);
$router->post('/aviones/eliminar', [AvionController::class, 'eliminar']);

$router->get('/', [VueloController::class, 'index']);
$router->get('/vuelos', [VueloController::class, 'index']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'procesarLogin']);

$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'procesarRegistro']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->post('/reservas/crear', [ReservaController::class, 'crear']);
$router->get('/mis-reservas', [ReservaController::class, 'misReservas']);

$router->dispatch();