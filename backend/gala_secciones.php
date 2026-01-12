<?php
require "conexion.php";
header("Content-Type: application/json");

$accion = $_GET['accion'] ?? '';

if ($accion === 'listar') {
    $res = $conexion->query("SELECT * FROM gala_secciones ORDER BY hora");
    $data = [];
    while ($f = $res->fetch_assoc()) $data[] = $f;
    echo json_encode($data);
    exit;
}

if ($accion === 'crear') {
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
    echo json_encode(['ok' => true]);
}
