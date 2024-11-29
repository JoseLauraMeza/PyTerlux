<?php
require_once(__DIR__.'/../models/candidato.php');

class CandidatoControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new CandidatoModel();
    }

    public function index()
    {
        $candidatos = $this->model->mostrar();
        require_once(__DIR__.'/../vista/candidatos/index.php');
    }

    public function nuevo()
    {
        require_once(__DIR__.'/../vista/candidatos/nuevo.php');
    }

    public function guardar()
    {
        $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
        $nombre_completo = filter_input(INPUT_POST, 'nombre_completo', FILTER_SANITIZE_STRING);
        $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
        $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
        $ubicacion = filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);

        if (empty($nombre_completo) || empty($fecha_nacimiento) || empty($genero) || empty($ubicacion) || empty($telefono)) {
            echo "Por favor, complete todos los campos correctamente.";
            return;
        }

        $this->model->insertar($usuario_id, $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono);
        header("Location: /mvc/candidatos/index.php");
    }

    public function editar()
    {
        $candidato_id = $_GET['id'];
        $candidato = $this->model->mostrar($candidato_id);
        if (!$candidato) {
            echo "Candidato no encontrado.";
            return;
        }
        require_once(__DIR__.'/../vista/candidatos/editar.php');
    }

    public function actualizar()
    {
        $candidato_id = filter_input(INPUT_POST, 'candidato_id', FILTER_VALIDATE_INT);
        $nombre_completo = filter_input(INPUT_POST, 'nombre_completo', FILTER_SANITIZE_STRING);
        $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
        $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
        $ubicacion = filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);

        if (!$candidato_id || empty($nombre_completo) || empty($fecha_nacimiento) || empty($genero) || empty($ubicacion) || empty($telefono)) {
            echo "Datos inválidos. Por favor, revisa los campos.";
            return;
        }

        $this->model->actualizar($candidato_id, $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono);
        header("Location: /mvc/candidatos/index.php");
    }

    public function eliminar()
    {
        $candidato_id = $_GET['id'];
        $this->model->eliminar($candidato_id);
        header("Location: /mvc/candidatos/index.php");
    }
}
?>
