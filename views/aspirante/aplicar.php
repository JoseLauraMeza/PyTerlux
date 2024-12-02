<?php
session_start();
require_once '../../models/Conexion.php';

// Verificar si el usuario es un aspirante
if ($_SESSION['tipo_usuario'] !== 'candidato') {
    echo "Acceso denegado.";
    exit;
}

// Obtener el ID del aspirante y la oferta
$candidato_id = $_SESSION['candidato_id']; // Suponiendo que está en la sesión
$oferta_id = filter_input(INPUT_GET, 'oferta_id', FILTER_VALIDATE_INT);

// Validar datos
if (!$oferta_id) {
    echo "ID de oferta inválido.";
    exit;
}

$conexion = Conexion::getConexion();

// Verificar si ya se postuló
$sql_verificar = "SELECT * FROM Postulaciones WHERE candidato_id = ? AND oferta_id = ?";
$stmt_verificar = $conexion->prepare($sql_verificar);
$stmt_verificar->bind_param("ii", $candidato_id, $oferta_id);
$stmt_verificar->execute();
$result = $stmt_verificar->get_result();

if ($result->num_rows > 0) {
    echo "Ya has aplicado a esta oferta.";
    exit;
}

// Insertar la postulación
$sql_insertar = "INSERT INTO Postulaciones (oferta_id, candidato_id, estado) VALUES (?, ?, 'pendiente')";
$stmt_insertar = $conexion->prepare($sql_insertar);
$stmt_insertar->bind_param("ii", $oferta_id, $candidato_id);

if ($stmt_insertar->execute()) {
    echo "¡Aplicación exitosa! Puedes revisar tu postulación en el dashboard.";
} else {
    echo "Hubo un error al aplicar. Por favor, inténtalo de nuevo.";
}
?>