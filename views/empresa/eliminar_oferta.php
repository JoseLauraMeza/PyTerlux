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

if (isset($_GET['id'])) {
    $oferta_id = $_GET['id'];
    $oferta = $ofertaControlador->obtenerOfertaPorId($oferta_id);

    // Verificar si la oferta pertenece a la empresa actual
    if ($oferta && $oferta['empresa_id'] == $_SESSION['usuario_id']) {
        $resultado = $ofertaControlador->eliminarOferta($oferta_id);
        
        if ($resultado) {
            header("Location: mis_ofertas.php?mensaje=Oferta eliminada correctamente");
            exit();
        } else {
            echo "Error al eliminar la oferta.";
        }
    } else {
        echo "No tienes permiso para eliminar esta oferta.";
    }
} else {
    echo "Oferta no encontrada.";
}
