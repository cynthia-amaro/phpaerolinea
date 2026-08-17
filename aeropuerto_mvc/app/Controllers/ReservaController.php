<?php

namespace App\Controllers;

use App\Models\Reserva;

class ReservaController
{
    public function crear(): void
    {
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debés iniciar sesión para reservar.';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $ci = (int) $_SESSION['usuario']['ci'];
        $idVuelo = (int) ($_POST['id_vuelo'] ?? 0);
        $clase = $_POST['clase'] ?? 'Turista';
        $costo = $_POST['costo'] ?? '0';

        if ($idVuelo <= 0) {
            $_SESSION['error'] = 'Vuelo inválido.';

            header('Location: ' . BASE_URL . '/vuelos');
            exit;
        }

        $ok = Reserva::crear($clase, $costo, $ci, $idVuelo);

        if ($ok) {
            $_SESSION['mensaje'] = 'Reserva realizada correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo realizar la reserva.';
        }

        header('Location: ' . BASE_URL . '/mis-reservas');
        exit;
    }

    public function misReservas(): void
    {
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = 'Debés iniciar sesión para ver tus reservas.';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $ci = (int) $_SESSION['usuario']['ci'];

        $reservas = Reserva::reservasDeCliente($ci);

        require_once __DIR__ . '/../Views/reservas/mis_reservas.php';
    }
}