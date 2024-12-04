<?php
session_start();
require_once '../../controller/ofertas.php'; // Incluir el controlador de ofertas

// Verificar si es una empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    header("Location: ../../login.php");
    exit();
}

// Instanciar el controlador de ofertas
$ofertaControlador = new Ofertas();
$ofertas = $ofertaControlador->obtenerOfertasPorEmpresa($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empresa</title>
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="../index.php"><img src="../img/logo.jpg" width="100"></a>
        </div>
        <ul class="nav-links">
            <li><a href="empresa_dashboard.php">Home</a></li>
            <li><a href="crear_oferta.php">Crear Oferta</a></li>
            <li><a href="mis_ofertas.php">Mis Ofertas</a></li>
            <li><a href="../logout.php" class="btn-logout">Cerrar sesión</a></li>
        </ul>
    </nav>

    <!-- Sección Hero -->
    <div class="hero">
        <h1>Encuentra el Trabajo de tus Sueños</h1>
        <p>Explora las mejores ofertas de trabajo, regístrate y empieza a postularte.</p>
    </div>

    <!-- Mostrar vacantes -->
    <div class="vacantes">
        <h2>Ofertas de Trabajo</h2>
        <ul class="vacantes-list">
            <?php if (!empty($ofertas)): ?>
                <?php foreach ($ofertas as $oferta): ?>
                    <li class="vacante">
                        <h3><?php echo htmlspecialchars($oferta['titulo']); ?></h3>
                        <p>Ubicación: <?php echo htmlspecialchars($oferta['ubicacion']); ?></p>
                        <p>Salario: $<?php echo number_format($oferta['salario'], 2); ?></p>
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
