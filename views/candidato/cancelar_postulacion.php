<?php
session_start();
require_once '../../controller/ofertas.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'candidato') {
    header("Location: ../../login.php");
    exit;
}

$postulacion_id = $_GET['id'];
$ofertasController = new Ofertas();

if ($ofertasController->cancelarPostulacion($postulacion_id)) {
    // Redirigir a la vista de postulaciones
    header("Location: ver_postulaciones.php");
    exit;
} else {
    // Si no se pudo cancelar la postulación
    echo "No se pudo cancelar la postulación. Verifica que el estado permita la cancelación.";
}
