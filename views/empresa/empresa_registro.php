<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    header("Location: ../index.php");
    exit();
}

require_once '../../controller/empresa.php';
$controlador = new EmpresaControlador();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador->guardar();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>
    <div class="form-section">
        <h2>Registrar Empresa</h2>
        <form action="empresa_registro.php" method="POST" class="form-container">
            <label for="nombre_empresa">Nombre de la Empresa</label>
            <input type="text" id="nombre_empresa" name="nombre_empresa" placeholder="Nombre de la empresa" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la empresa" required></textarea>

            <label for="ubicacion">Ubicación</label>
            <input type="text" id="ubicacion" name="ubicacion" placeholder="Ubicación" required>

            <label for="sitio_web">Sitio Web</label>
            <input type="url" id="sitio_web" name="sitio_web" placeholder="https://www.sitioweb.com" required>

            <input type="submit" value="Registrar">
        </form>
    </div>
</body>
</html>
