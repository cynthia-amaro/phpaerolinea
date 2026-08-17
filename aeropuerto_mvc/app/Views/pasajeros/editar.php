<?php

$pasajero = $pasajero ?? null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar pasajero</title>
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

<h1>Editar pasajero</h1>

<?php if (!$pasajero): ?>
    <p class="error">Pasajero no encontrado.</p>
<?php else: ?>

<form method="POST" action="/pasajeros/actualizar">
    <label>CI:</label>
    <input type="number" name="ci" value="<?= $pasajero['CI']; ?>" readonly>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($pasajero['Nombre']); ?>" required>

    <label>Credencial:</label>
    <input type="text" name="credencial" maxlength="10" value="<?= htmlspecialchars($pasajero['Credencial']); ?>" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nac" value="<?= $pasajero['FechaNac']; ?>" required>

    <button type="submit">Actualizar pasajero</button>
</form>

<?php endif; ?>

<p>
    <a href="/pasajeros">Volver</a>
</p>

</body>
</html>