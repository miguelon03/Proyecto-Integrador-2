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
    $res = $conexion->query("SELECT * FROM eventos ORDER BY fecha, hora");
    $eventos = [];
    while ($e = $res->fetch_assoc()) {
        $eventos[] = $e;
    }
    echo json_encode(['ok' => true, 'eventos' => $eventos]);
    exit;
}

/* CREAR */
if ($accion === 'crear') {
    if (
        empty($_POST['titulo']) ||
        empty($_POST['descripcion']) ||
        empty($_POST['fecha']) ||
        empty($_POST['hora'])
    ) {
        echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
        exit;
    }

    $stmt = $conexion->prepare("
        INSERT INTO eventos (titulo, descripcion, fecha, hora)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssss",
        $_POST['titulo'],
        $_POST['descripcion'],
        $_POST['fecha'],
        $_POST['hora']
    );
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

/* EDITAR */
if ($accion === 'editar') {
    $stmt = $conexion->prepare("
        UPDATE eventos
        SET titulo=?, descripcion=?, fecha=?, hora=?
        WHERE id_evento=?
    ");
    $stmt->bind_param(
        "ssssi",
        $_POST['titulo'],
        $_POST['descripcion'],
        $_POST['fecha'],
        $_POST['hora'],
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
