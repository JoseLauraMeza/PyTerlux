<?php
require_once(__DIR__.'/../models/administrador.php');

class AdministradorControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new AdministradorModel();
    }

    public function index()
    {
        $administradores = $this->model->mostrar();
        require_once(__DIR__.'/../vista/administradores/index.php');
    }

    public function nuevo()
    {
        require_once(__DIR__.'/../vista/administradores/nuevo.php');
    }

    public function guardar()
    {
        $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
        $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);

        if (empty($rol)) {
            echo "Por favor, complete todos los campos correctamente.";
            return;
        }

        $this->model->insertar($usuario_id, $rol);
        header("Location: /mvc/administradores/index.php");
    }

    public function editar()
    {
        $admin_id = $_GET['id'];
        $administrador = $this->model->mostrar($admin_id);
        if (!$administrador) {
            echo "Administrador no encontrado.";
            return;
        }
        require_once(__DIR__.'/../vista/administradores/editar.php');
    }

    public function actualizar()
    {
        $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);
        $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);

        if (!$admin_id || empty($rol)) {
            echo "Datos inválidos. Por favor, revisa los campos.";
            return;
        }

        $this->model->actualizar($admin_id, $rol);
        header("Location: /mvc/administradores/index.php");
    }

    public function eliminar()
    {
        $admin_id = $_GET['id'];
        $this->model->eliminar($admin_id);
        header("Location: /mvc/administradores/index.php");
    }
}
?>
