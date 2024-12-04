<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'candidato') {
    header("Location: ../index.php");
    exit();
}

require_once '../../controller/candidato.php';
$controlador = new CandidatoControlador();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador->guardar();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Candidato</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>
    <div class="form-section">
        <h2>Registrar Candidato</h2>
        <form action="candidato_registro.php" method="POST" class="form-container">
            <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">

            <label for="nombre_completo">Nombre Completo</label>
            <input type="text" id="nombre_completo" name="nombre_completo" placeholder="Nombre Completo" required>

            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

            <label for="genero">Género</label>
            <select id="genero" name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>

            <label for="ubicacion">Ubicación</label>
            <input type="text" id="ubicacion" name="ubicacion" placeholder="Ubicación" required>

            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required>

            <input type="submit" value="Registrar">
        </form>
    </div>
</body>
</html>
