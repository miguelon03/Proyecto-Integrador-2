<?php
require "conexion.php";
header("Content-Type: application/json");

$accion = $_GET['accion'] ?? '';

if ($accion === 'get') {
    $res = $conexion->query("SELECT modo FROM gala_estado WHERE id=1");
    echo json_encode($res->fetch_assoc());
    exit;
}

if ($accion === 'toggle') {
    $conexion->query("
        UPDATE gala_estado
        SET modo = IF(modo='pre','post','pre')
        WHERE id=1
    ");
    echo json_encode(['ok' => true]);
}
