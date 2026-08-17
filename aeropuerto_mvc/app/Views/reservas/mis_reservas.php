<?php

$reservas = $reservas ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis reservas</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<a href="/" class="logo-link">
    <img src="/assets/img/logo.png" alt="Logo Aerolínea" class="logo">
</a>

    <div class="nav-links">
        <a href="/vuelos">Vuelos</a>
        <a href="/aviones">Aviones</a>
        <a href="/pasajeros">Pasajeros</a>
        <a href="/tripulantes">Tripulantes</a>
        <a href="/asignaciones">Asignaciones</a>
        <a href="/mis-reservas">Mis reservas</a>

        <?php if (isset($_SESSION['usuario'])): ?>
            <span>Hola, <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
            <a href="/logout">Salir</a>
        <?php else: ?>
            <a href="/login">Login</a>
        <?php endif; ?>
    </div>
</nav>

<h1>Mis reservas</h1>

<?php if (isset($_SESSION['mensaje'])): ?>
    <p class="ok">
        <?= $_SESSION['mensaje']; ?>
        <?php unset($_SESSION['mensaje']); ?>
    </p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<?php if (empty($reservas)): ?>
    <p>No tenés reservas realizadas.</p>
<?php endif; ?>

<?php foreach ($reservas as $reserva): ?>
    <div class="card">
        <h3>Reserva #<?= $reserva['IDReserva']; ?></h3>

        <p><strong>Vuelo:</strong> <?= $reserva['IDVuelo']; ?></p>
        <p><strong>Clase:</strong> <?= htmlspecialchars($reserva['Clase']); ?></p>
        <p><strong>Costo:</strong> $<?= htmlspecialchars($reserva['Costo']); ?></p>
        <p><strong>Salida:</strong> <?= $reserva['FechaHoraS']; ?></p>
        <p><strong>Llegada:</strong> <?= $reserva['FechaHoraL']; ?></p>
        <p><strong>Avión:</strong> <?= htmlspecialchars($reserva['Matricula']); ?></p>
    </div>
<?php endforeach; ?>

</body>
</html>