<?php
require_once(__DIR__ . '/../models/aspirante.php');

class AspiranteControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new AspiranteModel();
    }

    // Mostrar datos del aspirante
    public function mostrar()
    {
        $usuario_id = $_SESSION['usuario_id'];
        $aspirante = $this->model->obtenerPorUsuarioId($usuario_id);

        if ($aspirante) {
            return $aspirante;
        } else {
            echo "Error: Aspirante no encontrado.";
        }
    }

    // Actualizar datos del aspirante
    public function actualizar()
    {
        $usuario_id = $_SESSION['usuario_id'];
        $nombre_completo = filter_input(INPUT_POST, 'nombre_completo', FILTER_SANITIZE_STRING);
        $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
        $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
        $ubicacion = filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);

        if (empty($nombre_completo) || empty($fecha_nacimiento) || empty($genero) || empty($ubicacion) || empty($telefono)) {
            echo "Por favor, complete todos los campos.";
            return;
        }

        $resultado = $this->model->actualizar($usuario_id, $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono);

        if ($resultado) {
            header("Location: aspirante_dashboard.php");
        } else {
            echo "Error al actualizar los datos. Intente nuevamente.";
        }
    }
}
?>