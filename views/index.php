<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa de Trabajo</title>
    <link rel="stylesheet" href="views/css/app.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">Logo</a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="controller/candidato.php">Login</a></li>
            <li><a href="controller/candidato.php">Registro</a></li>
        </ul>
    </nav>

    <div class="hero">
        <h1>Encuentra el Trabajo de tus Sueños</h1>
        <p>Explora las mejores ofertas de trabajo, regístrate y empieza a postularte.</p>
    </div>

    <div class="search-section">
        <h2>Buscar Ofertas de Trabajo</h2>
        <form action="index.php" method="get" class="search-form">
            <input type="text" name="query" placeholder="Busca por título, empresa, etc." required>
            <input type="submit" value="Buscar">
        </form>
    </div>

    <div class="vacantes">
        <h2>Ofertas de Trabajo</h2>
        <ul class="vacantes-list">
            <?php if (!empty($vacantes)): ?>
                <?php foreach ($vacantes as $vacante): ?>
                    <li class="vacante">
                        <h3><?php echo htmlspecialchars($vacante['titulo']); ?></h3>
                        <p>Ubicación: <?php echo htmlspecialchars($vacante['ubicacion']); ?></p>
                        <p>Salario: $<?php echo number_format($vacante['salario'], 2); ?></p>
                        <a href="#" class="btn-apply">Aplicar</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="vacante">
                    <p>No hay ofertas de trabajo disponibles en este momento.</p>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <footer>
        <p>&copy; 2024 Bolsa de Trabajo. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
