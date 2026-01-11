<?php
//Ponemos el require para crear la base de datos en cuanto abrimos el link del navegador
require "backend/BD.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header class="ue-header">
        <div class="main-nav">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo_uem.png" alt="Universidad Europea">
                </a>
            </div>

            <nav class="nav-links">
                <a href="#">Bases del Concurso</a>
                <a href="#">Inscripción</a>
                <a href="#">Ediciones Anteriores</a>
                <a href="#">Eventos</a>
                <select id="login" onchange="redirigirLogin(this.value)">
                    <option value="" selected disabled hidden>Entrar</option>
                    <option value="alumno">Alumno</option>
                    <option value="alumni">Alumni</option>
                    <option value="organizador">Organizador</option>
                </select>
            </nav>
        </div>
    </header>
    <main class="content">
    </main>
</body>
<script>
    function redirigirLogin(tipo) {
        if (tipo) {
            window.location.href = `login/login.php?tipo=${tipo}`;
        }
    }
</script>

</html>