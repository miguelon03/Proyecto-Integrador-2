<?php
require "backend/conexion.php";

$res = $conexion->query("
    SELECT * FROM ediciones
    ORDER BY anio DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ediciones Anteriores</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

<header class="ue-header">
    <div class="main-nav">
        <a href="index.php">⬅ Volver</a>
    </div>
</header>

<main class="content">

    <h1>Ediciones Anteriores</h1>

    <?php if ($res->num_rows === 0): ?>
        <p>No hay ediciones registradas todavía.</p>
    <?php endif; ?>

    <?php while ($e = $res->fetch_assoc()): ?>
        <div class="news-card">
            <h2>🎬 Edición <?= $e['anio'] ?></h2>

            <p><strong>Participantes:</strong> <?= $e['numero_participantes'] ?></p>

            <p><strong>Ganador Alumnos:</strong> <?= $e['ganador_alumnos'] ?></p>
            <p><strong>Ganador Alumni:</strong> <?= $e['ganador_alumni'] ?></p>
            <p><strong>Ganador Carrera:</strong> <?= $e['ganador_carrera'] ?></p>

            <?php if ($e['corto_alumnos']): ?>
                <p>
                    <a href="<?= $e['corto_alumnos'] ?>" target="_blank">
                        🎥 Ver corto alumnos
                    </a>
                </p>
            <?php endif; ?>

            <?php if ($e['corto_alumni']): ?>
                <p>
                    <a href="<?= $e['corto_alumni'] ?>" target="_blank">
                        🎥 Ver corto alumni
                    </a>
                </p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

</main>

</body>
</html>
