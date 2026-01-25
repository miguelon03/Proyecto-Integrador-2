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

                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="panel/personal.php" class="perfil-btn">Perfil</a>
                    <a href="logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <select id="login" onchange="redirigirLogin(this.value)">
                        <option value="" selected disabled hidden>Entrar</option>
                        <option value="alumno">Alumno</option>
                        <option value="alumni">Alumni</option>
                        <option value="organizador">Organizador</option>
                    </select>
                <?php endif; ?>
            </nav>

        </div>
    </header>

    <main class="content">
        <h1>Bienvenido/a al concurso</h1>
        <p>Tu inscripción ha sido enviada correctamente.</p>
    </main>

</body>

</html>