<?php
require "backend/conexion.php";
$res = $conexion->query("SELECT * FROM noticias ORDER BY fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<h1>Noticias del Festival</h1>

<?php if ($res->num_rows === 0): ?>
    <p>No hay noticias todavía.</p>
<?php endif; ?>

<?php while ($n = $res->fetch_assoc()): ?>
    <article class="news-card">
        <h3><?= htmlspecialchars($n['titulo']) ?></h3>
        <p><?= nl2br(htmlspecialchars($n['descripcion'])) ?></p>
        <small><?= $n['fecha'] ?></small>
    </article>
<?php endwhile; ?>

</body>
</html>
