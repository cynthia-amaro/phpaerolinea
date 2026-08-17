<?php

$vuelos = $vuelos ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vuelos</title>
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
<h1>Listado de vuelos</h1>

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

<?php if (empty($vuelos)): ?>
    <p>No hay vuelos cargados.</p>
<?php endif; ?>

<?php foreach ($vuelos as $vuelo): ?>
    <div class="card">
        <h3>Vuelo #<?= $vuelo['IDVuelo']; ?></h3>

        <p><strong>Salida:</strong> <?= $vuelo['FechaHoraS']; ?></p>
        <p><strong>Llegada:</strong> <?= $vuelo['FechaHoraL']; ?></p>
        <p><strong>Avión:</strong> <?= htmlspecialchars($vuelo['Matricula']); ?></p>

        <p>
            <a href="/vuelos/editar?id=<?= $vuelo['IDVuelo']; ?>">Editar</a>
        </p>

        <form method="POST" action="/vuelos/eliminar" onsubmit="return confirm('¿Seguro que querés eliminar este vuelo?');">
            <input type="hidden" name="id_vuelo" value="<?= $vuelo['IDVuelo']; ?>">
            <button type="submit">Eliminar</button>
        </form>

        <?php if (isset($_SESSION['usuario'])): ?>
            <hr>

            <form method="POST" action="/reservas/crear">
                <input type="hidden" name="id_vuelo" value="<?= $vuelo['IDVuelo']; ?>">

                <label>Clase:</label>
                <select name="clase">
                    <option value="Turista">Turista</option>
                    <option value="Ejecutiva">Ejecutiva</option>
                </select>

                <label>Costo:</label>
                <input type="text" name="costo" value="100">

                <button type="submit">Reservar</button>
            </form>
        <?php else: ?>
            <p><a href="/login">Iniciá sesión para reservar</a></p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>