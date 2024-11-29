<?php
require_once(__DIR__ . '/../models/usuario.php');

class UsuarioControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    public function guardar()
{
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING);
    $tipo_usuario = filter_input(INPUT_POST, 'tipo_usuario', FILTER_SANITIZE_STRING);

    if (empty($nombre) || empty($email) || empty($contrasena) || empty($tipo_usuario)) {
        echo "Por favor, complete todos los campos correctamente.";
        return false;
    }

    // Insertar usuario en la base de datos
    $usuario_id = $this->model->insertar($nombre, $email, $contrasena, $tipo_usuario);

    if ($usuario_id) {
        // Iniciar sesión del usuario
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['tipo_usuario'] = $tipo_usuario;

        // Redireccionar según el tipo de usuario
        $this->redirigirPorTipoUsuario($tipo_usuario);
    } else {
        echo "Error al registrar el usuario.";
    }
}

private function redirigirPorTipoUsuario($tipo_usuario)
{
    switch ($tipo_usuario) {
        case 'administrador':
            header("Location: views/admin/admin_registro.php");
            break;
        case 'candidato':
            header("Location: views/candidato/candidato_registro.php");
            break;
        case 'empresa':
            header("Location: views/empresa/empresa_registro.php");
            break;
        default:
            header("Location: index.php");
            break;
    }
    exit();
}


}
?>
