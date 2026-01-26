<?php
session_start();
require "conexion.php";

if ($_SESSION['tipo'] !== 'organizador') {
    echo json_encode(['ok' => false]);
    exit;
}

$res = $conexion->query("
    SELECT id_inscripcion, nombre_responsable, email, video, estado
    FROM inscripciones
    ORDER BY fecha DESC
");

$candidaturas = [];
while ($c = $res->fetch_assoc()) {
    $candidaturas[] = $c;
}

echo json_encode([
    'ok' => true,
    'candidaturas' => $candidaturas
]);
