<?php
require "../backend/conexion.php";

/* MODO */
$modo = $conexion->query(
    "SELECT modo FROM gala_estado WHERE id=1"
)->fetch_assoc()['modo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gala del Festival</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<h1>Gala del Festival</h1>

<?php if ($modo === 'pre'): ?>

    <h2>Programa de la Gala</h2>

    <?php
    $res = $conexion->query(
        "SELECT * FROM gala_secciones ORDER BY hora"
    );
    while ($s = $res->fetch_assoc()):
    ?>
        <div class="news-card">
            <strong><?= $s['hora'] ?></strong> – <?= $s['titulo'] ?> (<?= $s['sala'] ?>)
            <p><?= $s['descripcion'] ?></p>
        </div>
    <?php endwhile; ?>

<?php else: ?>

    <h2>Resumen de la Gala</h2>
    <?php
    $resumen = $conexion->query(
        "SELECT texto FROM gala_resumen WHERE id=1"
    )->fetch_assoc()['texto'];
    ?>
    <p><?= nl2br($resumen) ?></p>

    <h2>Ganadores del Festival</h2>
    <?php
    $res = $conexion->query("
        SELECT c.nombre AS categoria, g.nombre
        FROM ganadores g
        JOIN categorias c ON c.id_categoria = g.id_categoria
    ");
    while ($g = $res->fetch_assoc()):
    ?>
        <p><strong><?= $g['categoria'] ?>:</strong> <?= $g['nombre'] ?></p>
    <?php endwhile; ?>

    <h2>Galería de la Gala</h2>
    <?php
    $res = $conexion->query("SELECT imagen FROM gala_imagenes");
    while ($img = $res->fetch_assoc()):
    ?>
        <img src="../uploads/<?= $img['imagen'] ?>" width="200">
    <?php endwhile; ?>

<?php endif; ?>

</body>
</html>
