<?php

$aviones = $aviones ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aviones</title>
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

<h1>Gestión de aviones</h1>

<p>
    <a href="/aviones/crear">Crear nuevo avión</a>
</p>

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

<?php if (empty($aviones)): ?>
    <p>No hay aviones cargados.</p>
<?php endif; ?>

<?php foreach ($aviones as $avion): ?>
    <div class="card">
        <h3><?= htmlspecialchars($avion['Matricula']); ?></h3>

        <p><strong>Fabricante:</strong> <?= htmlspecialchars($avion['Fabricante']); ?></p>
        <p><strong>Modelo:</strong> <?= htmlspecialchars($avion['Modelo']); ?></p>
        <p><strong>Asientos:</strong> <?= $avion['Asientos']; ?></p>
        <p><strong>Carga:</strong> <?= $avion['Carga']; ?></p>

        <p>
            <a href="/aviones/editar?matricula=<?= urlencode($avion['Matricula']); ?>">Editar</a>
        </p>

        <form method="POST" action="/aviones/eliminar" onsubmit="return confirm('¿Seguro que querés eliminar este avión?');">
            <input type="hidden" name="matricula" value="<?= htmlspecialchars($avion['Matricula']); ?>">
            <button type="submit">Eliminar</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>