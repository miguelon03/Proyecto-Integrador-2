<?php
require "backend/conexion.php";

// Categorías con premios
$res = $conexion->query("
    SELECT c.nombre AS categoria, p.nombre AS premio, p.descripcion
    FROM categorias c
    LEFT JOIN premios p ON p.id_categoria = c.id_categoria
    ORDER BY c.nombre
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Premios</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

<header class="ue-header">
    <div class="main-nav">
        <a href="index.php">⬅ Volver</a>
    </div>
</header>

<main class="content">
    <h1>Premios del Festival</h1>

    <?php
    $actual = null;
    while ($p = $res->fetch_assoc()):
        if ($actual !== $p['categoria']):
            if ($actual !== null) echo "</ul>";
            $actual = $p['categoria'];
            echo "<h2>🏆 " . htmlspecialchars($actual) . "</h2><ul>";
        endif;
    ?>

        <?php if ($p['premio']): ?>
            <li>
                <strong><?= htmlspecialchars($p['premio']) ?></strong><br>
                <?= htmlspecialchars($p['descripcion']) ?>
            </li>
        <?php else: ?>
            <li><em>No hay premios asignados todavía</em></li>
        <?php endif; ?>

    <?php endwhile; ?>

    <?php if ($actual !== null) echo "</ul>"; ?>

</main>

</body>
</html>