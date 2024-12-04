<?php
session_start();
require_once '../../controller/ofertas.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'candidato') {
    header("Location: ../../login.php");
    exit;
}

$ofertasController = new OfertaControlador();
$postulaciones = $ofertasController->obtenerPostulacionesPorCandidato($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Postulaciones</title>
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

<div class="hero">
        <h1>Tus Postulaciones</h1>
    </div>

<div class="postulaciones">
    
    <?php if (!empty($postulaciones)): ?>
        <table class="tabla-postulaciones">
            <thead>
                <tr>
                    <th>Oferta</th>
                    <th>Fecha de Postulación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($postulaciones as $postulacion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($postulacion['titulo']); ?></td>
                        <td><?php echo $postulacion['fecha_postulacion']; ?></td>
                        <td><?php echo ucfirst($postulacion['estado']); ?></td>
                        <td>
                            <!-- Mostrar opción de cancelar solo si la postulación no está aceptada o rechazada -->
                            <?php if ($postulacion['estado'] === 'pendiente' || $postulacion['estado'] === 'en proceso'): ?>
                                <a href="cancelar_postulacion.php?id=<?php echo $postulacion['postulacion_id']; ?>" class="btn-cancelar">Cancelar</a>
                            <?php else: ?>
                                <p>No puede cancelar</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes postulaciones activas.</p>
    <?php endif; ?>
</div>

</body>
</html>
