<?php
session_start();
require_once '../../controller/ofertas.php'; // Incluir el controlador de ofertas

// Verificar si el usuario está autenticado y es una empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    header("Location: ../index.php");
    exit();
}

// Instanciar el controlador de ofertas
$ofertaControlador = new OfertaControlador();

// Obtener las ofertas de la empresa actual
$ofertas = $ofertaControlador->obtenerOfertasPorEmpresa($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ofertas</title>
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
        <h1>Mis Ofertas</h1>
    </div>

    <div class="dashboard-section">

        <?php if (isset($_GET['mensaje'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Salario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ofertas)): ?>
                    <?php foreach ($ofertas as $oferta): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($oferta['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($oferta['ubicacion']); ?></td>
                            <td><?php echo htmlspecialchars($oferta['salario']); ?></td>
                            <td>
                                <a href="editar_oferta.php?id=<?php echo $oferta['oferta_id']; ?>">Editar</a>
                                <a href="eliminar_oferta.php?id=<?php echo $oferta['oferta_id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No tienes ofertas publicadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
