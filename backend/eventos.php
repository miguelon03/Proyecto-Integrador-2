<?php
session_start();
header('Content-Type: application/json');

require "conexion.php";

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'organizador') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$accion = $_GET['accion'] ?? '';

/* ================= LISTAR ================= */
if ($accion === 'listar') {

    $res = $conexion->query("SELECT * FROM eventos ORDER BY fecha_inicio ASC");
    $eventos = [];

    while ($fila = $res->fetch_assoc()) {
        $eventos[] = $fila;
    }

    echo json_encode(['ok' => true, 'eventos' => $eventos]);
    exit;
}

/* ================= CREAR ================= */
if ($accion === 'crear') {

    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $inicio = $_POST['fecha_inicio'] ?? '';
    $fin = $_POST['fecha_fin'] ?? '';

    if ($titulo === '' || $descripcion === '' || !$inicio || !$fin) {
        echo json_encode(['ok' => false, 'error' => 'Campos obligatorios']);
        exit;
    }

    $stmt = $conexion->prepare(
        "INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $titulo, $descripcion, $inicio, $fin);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

/* ================= EDITAR ================= */
if ($accion === 'editar') {

    $id = intval($_POST['id'] ?? 0);
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $inicio = $_POST['fecha_inicio'] ?? '';
    $fin = $_POST['fecha_fin'] ?? '';

    if ($id <= 0) {
        echo json_encode(['ok' => false, 'error' => 'ID inválido']);
        exit;
    }

    $stmt = $conexion->prepare(
        "UPDATE eventos
         SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?
         WHERE id_evento=?"
    );
    $stmt->bind_param("ssssi", $titulo, $descripcion, $inicio, $fin, $id);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

/* ================= BORRAR ================= */
if ($accion === 'borrar') {

    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['ok' => false, 'error' => 'ID inválido']);
        exit;
    }

    $stmt = $conexion->prepare("DELETE FROM eventos WHERE id_evento=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

echo json_encode(['ok' => false, 'error' => 'Acción no válida']);
exit;
