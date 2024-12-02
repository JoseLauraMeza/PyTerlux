<?php
session_start();  // Iniciar sesión al comienzo del archivo

require_once __DIR__ . '/../models/usuario.php';  
require_once __DIR__ . '/../controller/usuario.php';

// Comprobar si la acción es 'login' y si la petición es POST
if (isset($_GET['action']) && $_GET['action'] === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear una instancia del controlador de Usuario
    $controller = new UsuarioControlador();

    // Obtener las credenciales del formulario
    $email = $_POST['email'];
    $contrasena = $_POST['password'];

    // Llamar a la función de autenticar
    $usuario = $controller->autenticar($email, $contrasena);

    // Si el usuario es válido, se redirige a su dashboard según el tipo
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['usuario_id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

        // Redirigir según el tipo de usuario
        switch ($usuario['tipo_usuario']) {
            case 'administrador':
                header('Location: ../views/admin/admin_dashboard.php');
                break;
            case 'candidato':
                header('Location: ../views/candidato/candidato_dashboard.php');
                break;
            case 'empresa':
                header('Location: ../views/empresa/empresa_dashboard.php');
                break;
            default:
                header('Location: index.php');
                break;
        }
        exit;
    } else {
        // Si las credenciales son incorrectas, mostrar error y redirigir de nuevo
        header('Location: login.php?error=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <!-- Formulario de inicio de sesión -->
    <form action="?action=login" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>

    <?php
    // Si hay un error al ingresar, mostrar mensaje
    if (isset($_GET['error'])) {
        echo "<p style='color: red;'>Correo o contraseña incorrectos.</p>";
    }
    ?>
</body>
</html>