<?php
// Asegúrate de iniciar sesión y verificar si el usuario es un aspirante
// session_start();
// if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'aspirante') {
//     header("Location: login.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aspirante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        .botones {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .boton {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .boton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido/a al Dashboard de Aspirante</h1>
    </header>
    <main>
        <div class="botones">
            <a href="aspirante_gestionar_cuenta.php" class="boton">Gestionar Cuenta</a>
            <a href="aspirante_buscar_empleo.php" class="boton">Buscar Empleo</a>
            <a href="aspirante_ver_postulaciones.php" class="boton">Ver Postulaciones</a>
        </div>
    </main>
</body>
</html>