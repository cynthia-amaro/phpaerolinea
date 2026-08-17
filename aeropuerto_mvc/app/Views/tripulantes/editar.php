<?php

$tripulante = $tripulante ?? null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar tripulante</title>
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

<h1>Editar tripulante</h1>

<?php if (!$tripulante): ?>
    <p class="error">Tripulante no encontrado.</p>
<?php else: ?>

<form method="POST" action="/tripulantes/actualizar">
    <label>CI:</label>
    <input type="number" name="ci" value="<?= $tripulante['CI']; ?>" readonly>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($tripulante['Nombre']); ?>" required>

    <label>Credencial:</label>
    <input type="text" name="credencial" maxlength="10" value="<?= htmlspecialchars($tripulante['Credencial']); ?>" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nac" value="<?= $tripulante['FechaNac']; ?>" required>

    <label>Cargo:</label>
    <select name="cargo" required>
        <?php
            $cargos = [
                'Piloto',
                'Copiloto',
                'Azafata',
                'Comisario de abordo',
                'Técnico'
            ];
        ?>

        <?php foreach ($cargos as $cargo): ?>
            <option 
                value="<?= htmlspecialchars($cargo); ?>"
                <?= $tripulante['Cargo'] === $cargo ? 'selected' : ''; ?>
            >
                <?= htmlspecialchars($cargo); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Actualizar tripulante</button>
</form>

<?php endif; ?>

<p>
    <a href="/tripulantes">Volver</a>
</p>

</body>
</html>