<?php

$avion = $avion ?? null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar avión</title>
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
<h1>Editar avión</h1>

<?php if (!$avion): ?>
    <p class="error">Avión no encontrado.</p>
<?php else: ?>

<form method="POST" action="/aviones/actualizar">
    <label>Matrícula:</label>
    <input type="text" name="matricula" value="<?= htmlspecialchars($avion['Matricula']); ?>" readonly>

    <label>Fabricante:</label>
    <input type="text" name="fabricante" value="<?= htmlspecialchars($avion['Fabricante']); ?>" required>

    <label>Asientos:</label>
    <input type="number" name="asientos" value="<?= $avion['Asientos']; ?>" required>

    <label>Carga:</label>
    <input type="number" name="carga" value="<?= $avion['Carga']; ?>" required>

    <label>Modelo:</label>
    <input type="text" name="modelo" value="<?= htmlspecialchars($avion['Modelo']); ?>" required>

    <button type="submit">Actualizar</button>
</form>

<?php endif; ?>

<p>
    <a href="/aviones">Volver</a>
</p>

</body>
</html>