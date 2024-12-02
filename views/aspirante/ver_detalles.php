<?php
session_start();
require_once '../models/Conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'aspirante') {
    header("Location: login.php");
    exit;
}

// Validar el parámetro recibido
if (!isset($_GET['oferta_id']) || !is_numeric($_GET['oferta_id'])) {
    echo "Oferta inválida.";
    exit;
}

$oferta_id = $_GET['oferta_id'];

// Conexión a la base de datos
$conexion = Conexion::getConexion();

// Consulta para obtener detalles de la oferta
$sql = "SELECT o.titulo, o.descripcion, o.ubicacion, o.salario, o.tipo_contrato, o.requisitos, e.nombre_empresa, e.correo_contacto 
        FROM Ofertas o
        JOIN Empresas e ON o.empresa_id = e.empresa_id
        WHERE o.oferta_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $oferta_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "La oferta no existe o ha sido eliminada.";
    exit;
}

$oferta = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Oferta</title>
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
        .detalle {
            margin: 20px auto;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .detalle h2 {
            margin-top: 0;
        }
        .detalle p {
            margin: 10px 0;
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
        <h1>Detalles de la Oferta</h1>
    </header>
    <main class="detalle">
        <h2><?= htmlspecialchars($oferta['titulo']); ?></h2>
        <p><strong>Empresa:</strong> <?= htmlspecialchars($oferta['nombre_empresa']); ?></p>
        <p><strong>Ubicación:</strong> <?= htmlspecialchars($oferta['ubicacion']); ?></p>
        <p><strong>Salario:</strong> $<?= number_format($oferta['salario'], 2); ?></p>
        <p><strong>Tipo de Contrato:</strong> <?= htmlspecialchars($oferta['tipo_contrato']); ?></p>
        <p><strong>Requisitos:</strong> <?= htmlspecialchars($oferta['requisitos']); ?></p>
        <p><strong>Descripción:</strong></p>
        <p><?= nl2br(htmlspecialchars($oferta['descripcion'])); ?></p>
        <p><strong>Correo de Contacto:</strong> <?= htmlspecialchars($oferta['correo_contacto']); ?></p>
        <div class="acciones">
            <a href="aplicar.php?oferta_id=<?= $oferta_id; ?>" class="btn btn-primary">Aplicar</a>
            <a href="aspirante_dashboard.php">Volver al Dashboard</a>
        </div>
    </main>
</body>
</html>