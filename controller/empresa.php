<?php
require_once(__DIR__ . '/../models/empresa.php');

class EmpresaControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new EmpresaModel();
    }

    // Método para guardar una nueva empresa
    public function guardar()
    {
        $usuario_id = $_SESSION['usuario_id'];
        $nombre_empresa = filter_input(INPUT_POST, 'nombre_empresa', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $ubicacion = filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING);
        $sitio_web = filter_input(INPUT_POST, 'sitio_web', FILTER_SANITIZE_URL);

        if (empty($nombre_empresa) || empty($descripcion) || empty($ubicacion) || empty($sitio_web)) {
            echo "Por favor, complete todos los campos.";
            return;
        }

        $resultado = $this->model->insertar($usuario_id, $nombre_empresa, $descripcion, $ubicacion, $sitio_web);

        if ($resultado) {
            // Redirigir al dashboard de la empresa o página principal
            header("Location: empresa_dashboard.php");
        } else {
            echo "Error al registrar la empresa. Intente nuevamente.";
        }
    }
}
?>
