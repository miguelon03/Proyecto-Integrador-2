<?php
session_start();
require "../backend/conexion.php";

$id_usuario = 1; // luego vendrá de sesión

$res = $conexion->query("
    SELECT * FROM inscripciones 
    WHERE id_usuario = $id_usuario
    ORDER BY fecha DESC
    LIMIT 1
");

$inscripcion = $res->fetch_assoc();
?>

<h1>Área personal</h1>

<?php if ($inscripcion): ?>
    <h2>Datos de la inscripción</h2>
    <p><strong>Responsable:</strong> <?= $inscripcion['nombre_responsable'] ?></p>
    <p><strong>Email:</strong> <?= $inscripcion['email'] ?></p>
    <p><strong>DNI:</strong> <?= $inscripcion['dni'] ?></p>
    <p>
        <strong>Vídeo:</strong>
        <a href="<?= $inscripcion['video'] ?>" target="_blank">
            Ver vídeo
        </a>
    </p>



    <h2>Estado de la candidatura</h2>
    <p><?= $inscripcion['estado'] ?></p>
<?php else: ?>
    <p>No tienes ninguna inscripción registrada.</p>
<?php endif; ?>