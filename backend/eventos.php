<?php
session_start();
header('Content-Type: application/json');
require "conexion.php";

/* SOLO ORGANIZADOR */
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'organizador') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$accion = $_GET['accion'] ?? '';

/* LISTAR */
if ($accion === 'listar') {
    $res = $conexion->query("SELECT * FROM eventos ORDER BY fecha_inicio ASC");
    $eventos = [];
    while ($e = $res->fetch_assoc()) {
        $eventos[] = $e;
    }
    echo json_encode(['ok' => true, 'eventos' => $eventos]);
    exit;
}

/* CREAR */
if ($accion === 'crear') {
    $stmt = $conexion->prepare("
        INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssss",
        $_POST['titulo'],
        $_POST['descripcion'],
        $_POST['fecha_inicio'],
        $_POST['fecha_fin']
    );
    $stmt->execute();
    echo json_encode(['ok' => true]);
    exit;
}

/* EDITAR */
if ($accion === 'editar') {
    $stmt = $conexion->prepare("
        UPDATE eventos
        SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?
        WHERE id_evento=?
    ");
    $stmt->bind_param(
        "ssssi",
        $_POST['titulo'],
        $_POST['descripcion'],
        $_POST['fecha_inicio'],
        $_POST['fecha_fin'],
        $_POST['id']
    );
    $stmt->execute();
    echo json_encode(['ok' => true]);
    exit;
}

/* BORRAR */
if ($accion === 'borrar') {
    $stmt = $conexion->prepare("DELETE FROM eventos WHERE id_evento=?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    echo json_encode(['ok' => true]);
    exit;
}

echo json_encode(['ok' => false, 'error' => 'Acción no válida']);
