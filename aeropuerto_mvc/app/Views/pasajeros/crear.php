<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear pasajero</title>
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

<h1>Crear pasajero</h1>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<form method="POST" action="/pasajeros/guardar">
    <label>CI:</label>
    <input type="number" name="ci" required>

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Credencial:</label>
    <input type="text" name="credencial" maxlength="10" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nac" required>

    <button type="submit">Guardar pasajero</button>
</form>

<p>
    <a href="/pasajeros">Volver</a>
</p>

</body>
</html>