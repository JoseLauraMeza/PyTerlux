<?php
// Asegúrate de iniciar sesión y verificar si el usuario es un aspirante
session_start();
require_once '../../controller/ofertas.php';
require_once '../../controller/postulacion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'candidato') {
    header("Location: ../../login.php");
    exit;
}

$ofertasController = new Ofertas();
$postulacionesController = new PostulacionController();

$usuario_id = $_SESSION['usuario_id'];

// Si hay una búsqueda con filtros, mostrar resultados de búsqueda
$query = '';
$ubicacion = '';
$categoria = '';
$salario_min = '';
$salario_max = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['query'])) {
    $query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);
    $ubicacion = filter_input(INPUT_GET, 'ubicacion', FILTER_SANITIZE_STRING);
    $categoria = filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_STRING);
    $salario_min = filter_input(INPUT_GET, 'salario_min', FILTER_VALIDATE_FLOAT);
    $salario_max = filter_input(INPUT_GET, 'salario_max', FILTER_VALIDATE_FLOAT);
    
    $vacantes = $ofertasController->buscarOfertasConFiltros($query, $ubicacion, $categoria, $salario_min, $salario_max);
} else {
    $vacantes = $ofertasController->obtenerOfertasActivas(10);
}

// Registrar la postulación si se presiona "Aplicar"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aplicar'])) {
    $oferta_id = $_POST['oferta_id'];

    // Verificar si el usuario ya aplicó a la oferta
    if (!$postulacionesController->haPostulado($usuario_id, $oferta_id)) {
        $postulacionesController->registrarPostulacion($usuario_id, $oferta_id);
        header("Location: candidato_dashboard.php"); // Recargar la página para actualizar los botones
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aspirante</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <a href="../index.php"><img src="../img/logo.jpg" width="100"></a>
    </div>
    <ul class="nav-links">
        <li><a href="candidato_dashboard.php">Home</a></li>
        <li><a href="ver_postulaciones.php">Ver Postulaciones</a></li>
        <li><a href="../../logout.php" class="btn-logout">Cerrar sesión</a></li>
    </ul>
</nav>

<!-- Sección Hero -->
<div class="hero">
    <h1>Bienvenido al dashboard aspirante</h1>
    <p>Explora las mejores ofertas de trabajo, regístrate y empieza a postularte.</p>
</div>

<div class="vacantes">
    <h2>Ofertas de Trabajo</h2>
    <ul class="vacantes-list">
        <?php if (!empty($vacantes)): ?>
            <?php foreach ($vacantes as $vacante): ?>
                <li class="vacante">
                    <h3><?php echo htmlspecialchars($vacante['titulo']); ?></h3>
                    <p>Ubicación: <?php echo htmlspecialchars($vacante['ubicacion']); ?></p>
                    <p>Salario: $<?php echo number_format($vacante['salario'], 2); ?></p>
                    <div>
                        <a href="ver_detalles.php?oferta_id=<?php echo $vacante['oferta_id']; ?>" class="btn btn-info">Ver detalles</a>

                        <?php if ($postulacionesController->haPostulado($usuario_id, $vacante['oferta_id'])): ?>
                            <button class="btn btn-success" disabled>Ya has postulado</button>
                        <?php else: ?>
                            <form action="candidato_dashboard.php" method="POST" style="display: inline;">
                                <input type="hidden" name="oferta_id" value="<?php echo $vacante['oferta_id']; ?>">
                                <button type="submit" name="aplicar" class="btn btn-primary">Aplicar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="vacante">
                <p>No hay ofertas de trabajo disponibles en este momento.</p>
            </li>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>
