<?php
session_start();
require "backend/BD.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <link rel="stylesheet" href="panel/styles.css">
</head>

<body>

    <header class="ue-header">
        <div class="main-nav">
            <div class="logo">
                <a href="home.php">
                    <img src="img/logo_uem.png" alt="Universidad Europea">
                </a>
            </div>

            <nav class="nav-links">
                <a href="#">Bases del Concurso</a>
                <a href="panel/inscripcion.php">Inscripción</a>
                <a href="#">Ediciones Anteriores</a>
                <a href="#">Eventos</a>

                <?php if (isset($_SESSION['id_usuario'])): ?>

                    <a href="panel/personal.php" class="perfil-btn">Perfil</a>
                    <a href="logout.php">Cerrar sesión</a>
                <?php else : ?>
                    <a href="logout.php">Cerrar sesión</a>
                <?php endif; ?>
            </nav>

        </div>
    </header>

    <main class="content">
    </main>

</body>

</html>