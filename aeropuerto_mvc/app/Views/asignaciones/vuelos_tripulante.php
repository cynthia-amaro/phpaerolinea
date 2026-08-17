<?php

$tripulante = $tripulante ?? null;
$asignaciones = $asignaciones ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vuelos del tripulante</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<nav class="navbar">
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

<?php if ($tripulante): ?>
    <h1>Vuelos de <?= htmlspecialchars($tripulante['Nombre']); ?></h1>

    <p><strong>CI:</strong> <?= $tripulante['CI']; ?></p>
    <p><strong>Cargo:</strong> <?= htmlspecialchars($tripulante['Cargo']); ?></p>
<?php endif; ?>

<?php if (empty($asignaciones)): ?>
    <p>Este tripulante no tiene vuelos asignados en la sesión actual.</p>
<?php endif; ?>

<?php foreach ($asignaciones as $asignacion): ?>
    <div class="card">
        <h3>Vuelo #<?= $asignacion['id_vuelo']; ?></h3>

        <p><strong>Salida:</strong> <?= $asignacion['fecha_salida']; ?></p>
        <p><strong>Llegada:</strong> <?= $asignacion['fecha_llegada']; ?></p>
        <p><strong>Avión:</strong> <?= htmlspecialchars($asignacion['matricula']); ?></p>
    </div>
<?php endforeach; ?>

<p>
    <a href="/tripulantes">Volver a tripulantes</a>
</p>

</body>
</html>