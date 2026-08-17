<?php

$asignaciones = $asignaciones ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignaciones</title>
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
    <?php if (isset($_SESSION['usuario'])): ?>
        <span>Hola, <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
        <a href="/logout">Salir</a>
    <?php else: ?>
        <a href="/login">Login</a>
    <?php endif; ?>
</nav>

<h1>Asignaciones de tripulantes a vuelos</h1>

<p>
    <a href="/asignaciones/crear">Asignar tripulante a vuelo</a>
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

<?php if (empty($asignaciones)): ?>
    <p>No hay tripulantes asignados a vuelos en esta sesión.</p>
<?php endif; ?>

<?php foreach ($asignaciones as $indice => $asignacion): ?>
    <div class="card">
        <h3>Vuelo #<?= $asignacion['id_vuelo']; ?></h3>
        

        <p><strong>Tripulante:</strong> <?= htmlspecialchars($asignacion['nombre_tripulante']); ?></p>
        <p><strong>CI:</strong> <?= $asignacion['ci_tripulante']; ?></p>
        <p><strong>Cargo:</strong> <?= htmlspecialchars($asignacion['cargo']); ?></p>
        <p><strong>Salida:</strong> <?= $asignacion['fecha_salida']; ?></p>
        <p><strong>Llegada:</strong> <?= $asignacion['fecha_llegada']; ?></p>
        <p><strong>Avión:</strong> <?= htmlspecialchars($asignacion['matricula']); ?></p>

        <form method="POST" action="/asignaciones/eliminar" onsubmit="return confirm('¿Seguro que querés eliminar esta asignación?');">
            <input type="hidden" name="indice" value="<?= $indice; ?>">
            <button type="submit">Eliminar asignación</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>