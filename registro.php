<?php
session_start();
require_once 'controller/usuario.php';

$registro_exitoso = "";
$registro_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $tipo_usuario = filter_input(INPUT_POST, 'tipo_usuario', FILTER_SANITIZE_STRING);

    if ($contrasena !== $confirmar_contrasena) {
        $registro_error = "Las contraseñas no coinciden.";
    } else {
        $usuarioController = new UsuarioControlador();
        $resultado = $usuarioController->guardar();

        if (!$resultado) {
            $registro_error = "Error en el registro. Verifica los campos e intenta nuevamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="views/css/app.css">
</head>
<body>
    <!-- Barra de navegación -->
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

    <!-- Sección Hero -->
    <div class="hero">
        <h1>Encuentra el Trabajo de tus Sueños</h1>
        <p>Explora las mejores ofertas de trabajo, regístrate y empieza a postularte.</p>
    </div>
    <!-- Contenido del formulario -->
    <div class="form-section">
        <h2>Formulario de Registro</h2>

        <?php if ($registro_error): ?>
            <p class="error"><?php echo htmlspecialchars($registro_error); ?></p>
        <?php endif; ?>

        <form action="registro.php" method="POST" class="form-container">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>

            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>

            <label for="confirmar_contrasena">Confirmar Contraseña</label>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>

            <label for="tipo_usuario">Tipo de Usuario</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="administrador">Administrador</option>
                <option value="candidato">Candidato</option>
                <option value="empresa">Empresa</option>
            </select>

            <input type="submit" value="Registrar">
        </form>
    </div>
</body>
</html>
