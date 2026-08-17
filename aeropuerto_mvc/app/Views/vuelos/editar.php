<?php

$vuelo = $vuelo ?? null;
$aviones = $aviones ?? [];

function convertirFechaParaInput(?string $fecha): string
{
    if (!$fecha) {
        return '';
    }

    return str_replace(' ', 'T', substr($fecha, 0, 16));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar vuelo</title>
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

<h1>Editar vuelo</h1>

<?php if (!$vuelo): ?>
    <p class="error">Vuelo no encontrado.</p>
<?php else: ?>

<form method="POST" action="/vuelos/actualizar">
    <input type="hidden" name="id_vuelo" value="<?= $vuelo['IDVuelo']; ?>">

    <label>Fecha y hora de salida:</label>
    <input 
        type="datetime-local" 
        name="fecha_hora_s" 
        value="<?= convertirFechaParaInput($vuelo['FechaHoraS']); ?>" 
        required
    >

    <label>Fecha y hora de llegada:</label>
    <input 
        type="datetime-local" 
        name="fecha_hora_l" 
        value="<?= convertirFechaParaInput($vuelo['FechaHoraL']); ?>" 
        required
    >

    <label>Avión:</label>
    <select name="matricula" required>
        <?php foreach ($aviones as $avion): ?>
            <option 
                value="<?= htmlspecialchars($avion['Matricula']); ?>"
                <?= $avion['Matricula'] === $vuelo['Matricula'] ? 'selected' : ''; ?>
            >
                <?= htmlspecialchars($avion['Matricula']); ?> -
                <?= htmlspecialchars($avion['Fabricante']); ?>
                <?= htmlspecialchars($avion['Modelo']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Actualizar vuelo</button>
</form>

<?php endif; ?>

<p>
    <a href="/vuelos">Volver</a>
</p>

</body>
</html>