<?php

$tripulantes = $tripulantes ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tripulantes</title>
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

<h1>Gestión de tripulantes</h1>

<p>
    <a href="/tripulantes/crear">Crear nuevo tripulante</a>
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

<?php if (empty($tripulantes)): ?>
    <p>No hay tripulantes cargados.</p>
<?php endif; ?>

<?php foreach ($tripulantes as $tripulante): ?>
    <div class="card">
        <h3><?= htmlspecialchars($tripulante['Nombre']); ?></h3>

        <p><strong>CI:</strong> <?= $tripulante['CI']; ?></p>
        <p><strong>Credencial:</strong> <?= htmlspecialchars($tripulante['Credencial']); ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?= $tripulante['FechaNac']; ?></p>
        <p><strong>Cargo:</strong> <?= htmlspecialchars($tripulante['Cargo']); ?></p>

        <p>
            <a href="/tripulantes/editar?ci=<?= $tripulante['CI']; ?>">Editar</a>
            |
            <a href="/tripulantes/vuelos?ci=<?= $tripulante['CI']; ?>">Ver vuelos asignados</a>
        </p>

        <form 
            method="POST" 
            action="/tripulantes/eliminar" 
            onsubmit="return confirm('¿Seguro que querés eliminar este tripulante?');"
        >
            <input type="hidden" name="ci" value="<?= $tripulante['CI']; ?>">
            <button type="submit">Eliminar</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>