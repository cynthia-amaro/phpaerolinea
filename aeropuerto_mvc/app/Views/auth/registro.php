<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Aeropuerto</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<nav>
    <a href="/vuelos">Vuelos</a>
    <a href="/login">Login</a>
    <a href="/registro">Registro</a>
</nav>

<h1>Registro de pasajero</h1>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<form method="POST" action="/registro">
    <label>CI:</label>
    <input type="number" name="ci" required>

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Credencial:</label>
    <input type="text" name="credencial" maxlength="10" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nac" required>

    <button type="submit">Registrarme</button>
</form>

<p>
    ¿Ya tenés cuenta?
    <a href="/login">Iniciar sesión</a>
</p>

</body>
</html>