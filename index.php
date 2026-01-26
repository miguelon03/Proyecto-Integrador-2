<?php
require "backend/BD.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Festival de Cortos – Universidad Europea</title>
    <link rel="stylesheet" href="css/index.css">
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
            <a href="noticias.php">Noticias</a>
            <a href="panel/eventos.html">Eventos</a>
            <a href="premios.php">Premios</a>
            <a href="panel/gala.php">Gala</a>
            <a href="ediciones.php">Ediciones anteriores</a>
            <a href="panel/inscripcion.php">Inscripción</a>

            <select id="login" onchange="redirigirLogin(this.value)">
                <option value="" selected disabled hidden>Entrar</option>
                <option value="participante">Participante</option>
                <option value="organizador">Organizador</option>
            </select>
        </nav>
    </div>
</header>

<main class="content">

    <section class="hero">
        <h1>Festival Universitario de Cortometrajes</h1>
        <p>
            Bienvenido al festival anual de cortos de la Universidad Europea.
            Descubre las mejores candidaturas, eventos, premios y galas.
        </p>
        <a href="panel/inscripcion.php" class="btn-principal">
            Inscribe tu candidatura
        </a>
    </section>

    <section class="bloques">
        <div class="bloque">
            <h2>📰 Noticias</h2>
            <p>Últimas novedades del festival.</p>
            <a href="noticias.php">Ver noticias</a>
        </div>

        <div class="bloque">
            <h2>📅 Eventos</h2>
            <p>Consulta el calendario completo.</p>
            <a href="panel/eventos.html">Ver eventos</a>
        </div>

        <div class="bloque">
            <h2>🏆 Premios</h2>
            <p>Categorías y galardones.</p>
            <a href="premios.php">Ver premios</a>
        </div>
    </section>

</main>

<script>
function redirigirLogin(tipo) {
    if (tipo) {
        window.location.href = `login/login.php?tipo=${tipo}`;
    }
}
</script>

</body>
</html>
