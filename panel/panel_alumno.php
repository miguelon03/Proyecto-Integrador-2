<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'alumno') {

    header("Location: ../index.php");
    exit;
}
?>

<?php
require "../backend/conexion.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>

    <header class="ue-header">
        <div class="main-nav">
            <div class="logo">
                    <img src="../img/logo_uem.png" alt="Universidad Europea">
            </div>

            <nav class="nav-links">
                <a href="#">Bases del Concurso</a>
                <a href="#">Inscripción</a>
                <a href="#">Ediciones Anteriores</a>
                <a href="#">Eventos</a>
                <a href="../logout.php">Cerrar Sesión</a>

            </nav>
        </div>
    </header>
    <main class="content">
    </main>
</body>

</html>