<?php
session_start();
require_once '../models/Conexion.php';

// if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'aspirante') {
//     header("Location: login.php");
//     exit;
// }

// Conexión a la base de datos
$conexion = Conexion::getConexion();

// Consulta para obtener ofertas activas
$sql = "SELECT o.oferta_id, o.titulo, o.descripcion, o.ubicacion, o.salario, e.nombre_empresa 
        FROM Ofertas o
        JOIN Empresas e ON o.empresa_id = e.empresa_id
        WHERE o.estado = 'activa'";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Empleo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .empleos {
            margin: 20px auto;
            max-width: 800px;
        }
        .empleo {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .empleo h3 {
            margin: 0 0 10px;
        }
        .empleo p {
            margin: 5px 0;
        }
        .acciones a {
            color: white;
            background-color: #007bff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            display: inline-block;
        }
        .acciones a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Buscar Empleo</h1>
    </header>
    <main class="empleos">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="empleo">
                    <h3><?= htmlspecialchars($row['titulo']); ?></h3>
                    <p><strong>Empresa:</strong> <?= htmlspecialchars($row['nombre_empresa']); ?></p>
                    <p><strong>Ubicación:</strong> <?= htmlspecialchars($row['ubicacion']); ?></p>
                    <p><strong>Salario:</strong> $<?= number_format($row['salario'], 2); ?></p>
                    <p><?= htmlspecialchars(substr($row['descripcion'], 0, 100)) . '...'; ?></p>
                    <div class="acciones">
                        <a href="ver_detalles.php?oferta_id=<?= $row['oferta_id']; ?>">Ver Detalles</a>
                        <a href="aplicar.php?oferta_id=<?= $row['oferta_id']; ?>">Aplicar</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay ofertas de empleo disponibles actualmente.</p>
        <?php endif; ?>
    </main>
</body>
</html>