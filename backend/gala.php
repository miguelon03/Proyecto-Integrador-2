<?php
session_start();
require "conexion.php";
header("Content-Type: application/json");

$accion = $_GET['accion'] ?? '';

if ($accion === 'estado') {
    $res = $conexion->query("SELECT modo FROM gala_estado WHERE id=1");
    echo json_encode($res->fetch_assoc());
    exit;
}

if ($accion === 'cambiarModo') {
    $conexion->query("
        UPDATE gala_estado
        SET modo = IF(modo='pre','post','pre')
        WHERE id=1
    ");
    exit;
}

if ($accion === 'listarSecciones') {
    $res = $conexion->query("
        SELECT * FROM gala_secciones ORDER BY hora
    ");
    $data = [];
    while($f = $res->fetch_assoc()) $data[] = $f;
    echo json_encode($data);
    exit;
}

if ($accion === 'crearSeccion') {
    $stmt = $conexion->prepare("
        INSERT INTO gala_secciones (titulo, hora, sala, descripcion)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssss",
        $_POST['titulo'],
        $_POST['hora'],
        $_POST['sala'],
        $_POST['descripcion']
    );
    $stmt->execute();
    exit;
}
if ($accion === 'textoPost') {
    $res = $conexion->query("SELECT texto FROM gala_post WHERE id=1");
    echo json_encode($res->fetch_assoc());
    exit;
}

if ($accion === 'imagenes') {
    $res = $conexion->query("SELECT imagen FROM gala_imagenes");
    $data = [];
    while ($f = $res->fetch_assoc()) $data[] = $f;
    echo json_encode($data);
    exit;
}

if ($accion === 'ganadores') {
    $res = $conexion->query("
        SELECT c.nombre AS categoria, g.nombre
        FROM ganadores g
        JOIN categorias c ON c.id_categoria = g.id_categoria
    ");
    $data = [];
    while ($f = $res->fetch_assoc()) $data[] = $f;
    echo json_encode($data);
    exit;
}

