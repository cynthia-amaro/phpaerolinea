<?php

$vuelos = $vuelos ?? [];
$tripulantes = $tripulantes ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar tripulante</title>
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

<h1>Asignar tripulante a vuelo</h1>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error">
        <?= $_SESSION['error']; ?>
        <?php unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<form method="POST" action="/asignaciones/guardar">
    <label>Vuelo:</label>
    <select name="id_vuelo" required>
        <option value="">Seleccione un vuelo</option>

        <?php foreach ($vuelos as $vuelo): ?>
            <option value="<?= $vuelo['IDVuelo']; ?>">
                Vuelo #<?= $vuelo['IDVuelo']; ?> |
                Salida: <?= $vuelo['FechaHoraS']; ?> |
                Avión: <?= htmlspecialchars($vuelo['Matricula']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Tripulante:</label>
    <select name="ci_tripulante" required>
        <option value="">Seleccione un tripulante</option>

        <?php foreach ($tripulantes as $tripulante): ?>
            <option value="<?= $tripulante['CI']; ?>">
                <?= htmlspecialchars($tripulante['Nombre']); ?> |
                CI: <?= $tripulante['CI']; ?> |
                Cargo: <?= htmlspecialchars($tripulante['Cargo']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Asignar</button>
</form>

<p>
    <a href="/asignaciones">Volver</a>
</p>

</body>
</html>