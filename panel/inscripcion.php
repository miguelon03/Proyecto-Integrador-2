<?php
session_start();
require "../backend/conexion.php";

$tieneInscripcion = false;
$total = 0;

// SOLO si existe usuario en sesión
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    $res = $conexion->query("
        SELECT COUNT(*) AS total
        FROM inscripciones
        WHERE id_usuario = $id_usuario
    ");
    $total = $res->fetch_assoc()['total'];

    if ($total >= 2) {
        header("Location: personal.php");
        exit;
    }

    $tieneInscripcion = $total > 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $tieneInscripcion ? 'Nueva candidatura' : 'Inscripción' ?></title>
</head>

<body>

<style>
.form-container {
    position: relative;
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(226,8,8,.9);
}
.form-container h1 { text-align:center; margin-bottom:25px; }
.form-group { display:flex; flex-direction:column; margin-bottom:15px; }
.form-group label { font-weight:600; margin-bottom:6px; }
.form-group input, textarea {
    padding:10px; border-radius:6px; border:1px solid #ccc;
}
.btn-submit {
    background:red; color:white; padding:12px;
    border:none; border-radius:6px; cursor:pointer;
}
.btn-cerrar {
    position:absolute; top:15px; right:15px;
    font-size:22px; color:red; text-decoration:none;
}
</style>

<div class="form-container">
    <a href="../home.php" class="btn-cerrar">✖</a>

    <h1><?= $tieneInscripcion ? 'Nueva candidatura' : 'Inscripción al concurso' ?></h1>

    <form action="../backend/inscripcion_guardar.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Ficha técnico-artística</label>
            <input type="file" name="ficha" required>
        </div>

        <div class="form-group">
            <label>Cartel</label>
            <input type="file" name="cartel" required>
        </div>

        <div class="form-group">
            <label>Sinopsis</label>
            <textarea name="sinopsis" required></textarea>
        </div>

        <?php if (!isset($_SESSION['id_usuario'])): ?>
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="nombre_responsable" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>DNI</label>
                <input type="text" name="dni" required>
            </div>

            <div class="form-group">
                <label>Nº Expediente</label>
                <input type="text" name="expediente" required>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Vídeo (enlace)</label>
            <input type="url" name="video" required>
        </div>

        <button class="btn-submit">
            <?= $tieneInscripcion ? 'Enviar nueva candidatura' : 'Enviar inscripción' ?>
        </button>
    </form>
</div>

</body>
</html>
