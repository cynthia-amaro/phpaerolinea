<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear tripulante</title>
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
<h1>Crear tripulante</h1>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<form method="POST" action="/tripulantes/guardar">
    <label>CI:</label>
    <input type="number" name="ci" required>

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Credencial:</label>
    <input type="text" name="credencial" maxlength="10" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nac" required>

    <label>Cargo:</label>
    <select name="cargo" required>
        <option value="">Seleccione un cargo</option>
        <option value="Piloto">Piloto</option>
        <option value="Copiloto">Copiloto</option>
        <option value="Azafata">Azafata</option>
        <option value="Comisario de abordo">Comisario de abordo</option>
        <option value="Técnico">Técnico</option>
    </select>

    <button type="submit">Guardar tripulante</button>
</form>

<p>
    <a href="/tripulantes">Volver</a>
</p>

</body>
</html>