<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Aeropuerto</title>
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
<h1>Iniciar sesión</h1>

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

<form method="POST" action="/login">
    <label>CI:</label>
    <input type="number" name="ci" required>

    <label>Credencial:</label>
    <input type="text" name="credencial" required>

    <button type="submit">Ingresar</button>
</form>

<p>
    ¿No tenés cuenta?
    <a href="/registro">Registrarme</a>
</p>

</body>
</html>