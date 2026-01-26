<?php
session_start();
require "../backend/conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../home.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$res = $conexion->query("
    SELECT *
    FROM inscripciones
    WHERE id_usuario = $id_usuario
    ORDER BY fecha DESC
");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Área personal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error {
            color: red;
            font-size: 12px;
        }

        .campo {
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
        }

        .btn-guardar {
            background: #0077cc;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 6px;
        }

        .readonly {
            background: #f5f5f5;
        }
    </style>
</head>

<body>

    <header class="ue-header">
        <div class="main-nav">
            <div class="logo">
                <a href="../home.php">
                    <img src="../img/logo_uem.png" alt="Universidad Europea">
                </a>
            </div>
            <nav class="nav-links">
                <a href="inscripcion.php">Inscripción</a>
                <a href="../logout.php">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main class="content">
        <h1>Área personal</h1>

        <?php while ($c = $res->fetch_assoc()): ?>
            <form class="news-card editarForm" method="POST" action="../backend/personal_actualizar.php">

                <input type="hidden" name="id_inscripcion" value="<?= $c['id_inscripcion'] ?>">

                <div class="campo">
                    <label>Responsable</label>
                    <input type="text" name="nombre_responsable" value="<?= htmlspecialchars($c['nombre_responsable']) ?>">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($c['email']) ?>">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>DNI</label>
                    <input type="text" name="dni" value="<?= htmlspecialchars($c['dni']) ?>">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Expediente</label>
                    <input type="text" name="expediente" value="<?= htmlspecialchars($c['expediente']) ?>">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Sinopsis</label>
                    <textarea name="sinopsis"><?= htmlspecialchars($c['sinopsis']) ?></textarea>
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Vídeo (no editable)</label>
                    <input type="text" value="<?= htmlspecialchars($c['video']) ?>" readonly class="readonly">
                </div>

                <p><strong>Estado:</strong> <?= $c['estado'] ?></p>
                <?php if ($c['estado'] === 'RECHAZADO'): ?>
                    <p><strong>Motivo:</strong> <?= htmlspecialchars($c['motivo_rechazo']) ?></p>

                    <form method="POST" action="../backend/subsanar.php">
                        <input type="hidden" name="id_inscripcion" value="<?= $c['id_inscripcion'] ?>">
                        <textarea name="mensaje" required>Errores subsanados</textarea>
                        <button>Enviar subsanación</button>
                    </form>
                <?php endif; ?>

                <button class="btn-guardar">Guardar cambios</button>
            </form>
        <?php endwhile; ?>

    </main>

    <script>
        document.querySelectorAll(".editarForm").forEach(form => {
            form.addEventListener("submit", e => {
                let ok = true;
                form.querySelectorAll("input:not([readonly]), textarea").forEach(campo => {
                    const error = campo.nextElementSibling;
                    if (campo.value.trim() === "") {
                        error.textContent = "Campo obligatorio";
                        ok = false;
                    } else {
                        error.textContent = "";
                    }
                });
                if (!ok) e.preventDefault();
            });
        });
    </script>

</body>

</html>