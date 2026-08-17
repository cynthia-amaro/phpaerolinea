<?php

$aviones = $aviones ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear vuelo</title>
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

<h1>Crear vuelo</h1>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<form method="POST" action="/vuelos/guardar">
    <label>Fecha y hora de salida:</label>
    <input type="datetime-local" name="fecha_hora_s" required>

    <label>Fecha y hora de llegada:</label>
    <input type="datetime-local" name="fecha_hora_l" required>

    <label>Avión:</label>
    <select name="matricula" required>
        <option value="">Seleccione un avión</option>

        <?php foreach ($aviones as $avion): ?>
            <option value="<?= htmlspecialchars($avion['Matricula']); ?>">
                <?= htmlspecialchars($avion['Matricula']); ?> -
                <?= htmlspecialchars($avion['Fabricante']); ?>
                <?= htmlspecialchars($avion['Modelo']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Guardar vuelo</button>
</form>

<p>
    <a href="/vuelos">Volver</a>
</p>

</body>
</html>