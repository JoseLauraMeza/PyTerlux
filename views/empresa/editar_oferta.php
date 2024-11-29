<?php
session_start();
require_once '../../controller/ofertas.php'; // Incluir el controlador de ofertas

// Verificar si el usuario es una empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    header("Location: ../index.php");
    exit();
}

// Instanciar el controlador de ofertas
$ofertaControlador = new OfertaControlador();
$error = "";

// Obtener la oferta a editar
if (isset($_GET['id'])) {
    $oferta_id = $_GET['id'];
    $oferta = $ofertaControlador->obtenerOfertaPorId($oferta_id);

    // Verificar si la oferta pertenece a la empresa actual
    if (!$oferta || $oferta['empresa_id'] != $_SESSION['usuario_id']) {
        echo "No tienes permiso para editar esta oferta.";
        exit();
    }
} else {
    echo "Oferta no encontrada.";
    exit();
}

// Procesar la actualización del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $requisitos = filter_input(INPUT_POST, 'requisitos', FILTER_SANITIZE_STRING);
    $ubicacion = filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING);
    $salario = filter_input(INPUT_POST, 'salario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Actualizar la oferta a través del controlador
    $resultado = $ofertaControlador->actualizarOferta($oferta_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario);

    if ($resultado) {
        header("Location: mis_ofertas.php?mensaje=Oferta actualizada correctamente");
        exit();
    } else {
        $error = "Error al actualizar la oferta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Oferta</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>
    <nav class="navbar">
        <a href="empresa_dashboard.php">Dashboard</a>
    </nav>

    <div class="form-section">
        <h2>Editar Oferta de Trabajo</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="editar_oferta.php?id=<?php echo $oferta_id; ?>" method="POST">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($oferta['titulo']); ?>" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($oferta['descripcion']); ?></textarea>

            <label for="requisitos">Requisitos</label>
            <textarea id="requisitos" name="requisitos" required><?php echo htmlspecialchars($oferta['requisitos']); ?></textarea>

            <label for="ubicacion">Ubicación</label>
            <input type="text" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($oferta['ubicacion']); ?>" required>

            <label for="salario">Salario</label>
            <input type="number" step="0.01" id="salario" name="salario" value="<?php echo htmlspecialchars($oferta['salario']); ?>" required>

            <input type="submit" value="Actualizar Oferta">
        </form>
    </div>
</body>
</html>
