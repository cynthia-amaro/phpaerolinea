<?php

namespace App\Core;

class Router
{
    private array $rutas = [];

    public function get(string $ruta, array $accion): void
    {
        $this->rutas['GET'][$ruta] = $accion;
    }

    public function post(string $ruta, array $accion): void
    {
        $this->rutas['POST'][$ruta] = $accion;
    }

    public function dispatch(): void
    {
        $metodoHttp = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        $uri = rtrim($uri, '/');

        if ($uri === '') {
            $uri = '/';
        }

        if (!isset($this->rutas[$metodoHttp][$uri])) {
            http_response_code(404);
            echo 'Página no encontrada';
            return;
        }

        [$controller, $metodoController] =
            $this->rutas[$metodoHttp][$uri];

        $objetoController = new $controller();
        $objetoController->$metodoController();
    }
}