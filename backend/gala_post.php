<?php
require "conexion.php";
header("Content-Type: application/json");

$accion = $_GET['accion'] ?? '';

/* ===============================
   GUARDAR TEXTO RESUMEN
================================ */
if ($accion === 'guardarResumen') {
    $stmt = $conexion->prepare("
        UPDATE gala_resumen SET texto=? WHERE id=1
    ");
    $stmt->bind_param("s", $_POST['texto']);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

/* ===============================
   SUBIR IMAGEN
================================ */
if ($accion === 'subirImagen') {

    if (!isset($_FILES['imagen'])) {
        echo json_encode(['error' => 'No se recibió imagen']);
        exit;
    }

    $nombre = time() . "_" . $_FILES['imagen']['name'];
    $ruta = "../uploads/" . $nombre;

    if (!is_dir("../uploads")) {
        mkdir("../uploads", 0777, true);
    }

    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

    $stmt = $conexion->prepare("
        INSERT INTO gala_imagenes (imagen)
        VALUES (?)
    ");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}
