<?php
session_start();
require_once '../../controller/ofertas.php'; // Incluir el controlador de ofertas

// Verificar si el usuario está autenticado y es una empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 'empresa') {
    header("Location: ../../index.php"); // Redirigir si no está autenticado o no es una empresa
    exit();
}

// Instanciar el controlador de ofertas
$ofertaControlador = new OfertaControlador();
$mensaje_error = "";
$mensaje_exito = "";

// Manejar la lógica del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $requisitos = filter_input(INPUT_POST, 'requisitos', FILTER_SANITIZE_STRING);
    $ubicacion = filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING);
    $salario = filter_input(INPUT_POST, 'salario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_SANITIZE_NUMBER_INT);
    $empresa_id = $_SESSION['usuario_id'];

    // Validación básica
    if (empty($titulo) || empty($descripcion) || empty($requisitos) || empty($ubicacion) || empty($salario) || empty($categoria_id)) {
        $mensaje_error = "Por favor, completa todos los campos.";
    } else {
        // Llamar al controlador para crear la oferta
        $resultado = $ofertaControlador->crearOferta($empresa_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario, $categoria_id);

        if ($resultado) {
            $mensaje_exito = "Oferta creada exitosamente.";
        } else {
            $mensaje_error = "Hubo un error al crear la oferta. Intenta nuevamente.";
        }
    }
}

// Obtener las categorías para mostrarlas en el formulario
$categorias = $ofertaControlador->obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Oferta</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="../index.php"><img src="../img/logo.jpg" width="100"></a>
        </div>
        <ul class="nav-links">
            <li><a href="empresa_dashboard.php">Home</a></li>
            <li><a href="mis_ofertas.php">Mis Ofertas</a></li>
            <li><a href="../../logout.php" class="btn-logout">Cerrar sesión</a></li>
        </ul>
    </nav>

    <div class="form-section">
        <h2>Crear Nueva Oferta de Trabajo</h2>

        <?php if ($mensaje_error): ?>
            <p class="error"><?php echo $mensaje_error; ?></p>
        <?php endif; ?>

        <?php if ($mensaje_exito): ?>
            <p class="success"><?php echo $mensaje_exito; ?></p>
        <?php endif; ?>

        <form action="crear_oferta.php" method="POST" class="form-container">
            <label for="titulo">Título de la Oferta</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción del trabajo" required></textarea>

            <label for="requisitos">Requisitos</label>
            <textarea id="requisitos" name="requisitos" placeholder="Requisitos del trabajo" required></textarea>

            <label for="ubicacion">Ubicación</label>
            <input type="text" id="ubicacion" name="ubicacion" placeholder="Ubicación del trabajo" required>

            <label for="salario">Salario</label>
            <input type="text" id="salario" name="salario" placeholder="Salario" required>

            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['categoria_id']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Crear Oferta">
        </form>
    </div>

</body>
</html>
