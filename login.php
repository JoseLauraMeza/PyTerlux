<?php
session_start();
require_once 'controller/usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $usuarioControlador = new UsuarioControlador();
    $resultado = $usuarioControlador->iniciarSesion($email, $password);

    if ($resultado) {
        if ($_SESSION['tipo_usuario'] == 'admin') {
            header('Location: views/admin/admin_dashboard.php');
        } elseif ($_SESSION['tipo_usuario'] == 'empresa') {
            header('Location: views/empresa/empresa_dashboard.php');
        } else {
            header('Location: views/candidato/candidato_dashboard.php');
        }
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="views/css/app.css">
</head>
<body>
<nav class="navbar">
        <div class="logo">
            <a href="index.php"><img src="views/img/logo.jpg" width="100"></a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li><a href="logout.php" class="btn-logout">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn-login">Login</a></li>
                <li><a href="registro.php" class="btn-register">Registrar</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="hero">
        <h1>Encuentra el Trabajo de tus Sueños</h1>
        <p>Explora las mejores ofertas de trabajo, regístrate y empieza a postularte.</p>
    </div>
    <div class="form-section">
        <h2>Bienvenido de nuevo...</h2>

    <div class="form-section">
    <h1>Iniciar Sesión</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="login.php" class="form-container">
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar Sesion">
    </form>
    </div>
    
</body>
</html>
