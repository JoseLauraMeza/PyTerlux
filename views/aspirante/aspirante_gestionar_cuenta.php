<?php
require_once '../../controllers/aspirante.php';
$controlador = new AspiranteControlador();
$aspirante = $controlador->mostrar();
?>

<h1>Gestionar Cuenta</h1>
<form method="POST" action="../../controllers/aspirante.php?action=actualizar">
    <label for="nombre_completo">Nombre Completo:</label>
    <input type="text" name="nombre_completo" value="<?= $aspirante['nombre_completo'] ?>" required>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" name="fecha_nacimiento" value="<?= $aspirante['fecha_nacimiento'] ?>" required>

    <label for="genero">Género:</label>
    <select name="genero" required>
        <option value="M" <?= $aspirante['genero'] == 'M' ? 'selected' : '' ?>>Masculino</option>
        <option value="F" <?= $aspirante['genero'] == 'F' ? 'selected' : '' ?>>Femenino</option>
        <option value="Otro" <?= $aspirante['genero'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
    </select>

    <label for="ubicacion">Ubicación:</label>
    <input type="text" name="ubicacion" value="<?= $aspirante['ubicacion'] ?>" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" value="<?= $aspirante['telefono'] ?>" required>

    <button type="submit">Actualizar</button>
</form>