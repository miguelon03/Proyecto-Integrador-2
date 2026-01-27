<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'organizador') {
    echo json_encode(['ok'=>false,'error'=>'No autorizado']);
    exit;
}

$accion = $_GET['accion'] ?? '';

if ($accion === 'listar') {
    $res = $conexion->query("
        SELECT id_inscripcion, nombre_responsable, estado
        FROM inscripciones
        ORDER BY fecha DESC
    ");

    echo json_encode([
        'candidaturas' => $res->fetch_all(MYSQLI_ASSOC)
    ]);
    exit;
}
