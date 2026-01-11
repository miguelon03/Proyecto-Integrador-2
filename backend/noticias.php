<?php
session_start();
header('Content-Type: application/json');

require "conexion.php";

/* =======================
   SEGURIDAD: SOLO ORGANIZADOR
======================= */
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'organizador') {
    echo json_encode([
        'ok' => false,
        'error' => 'No autorizado'
    ]);
    exit;
}

/* =======================
   ACCIÓN
======================= */
$accion = $_GET['accion'] ?? '';

/* =======================
   LISTAR NOTICIAS
======================= */
if ($accion === 'listar') {

    $res = $conexion->query("SELECT * FROM noticias ORDER BY fecha DESC");
    $noticias = [];

    while ($fila = $res->fetch_assoc()) {
        $noticias[] = $fila;
    }

    echo json_encode([
        'ok' => true,
        'noticias' => $noticias
    ]);
    exit;
}

/* =======================
   CREAR NOTICIA
======================= */
if ($accion === 'crear') {

    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($titulo === '' || $descripcion === '') {
        echo json_encode([
            'ok' => false,
            'error' => 'No se pueden guardar noticias vacías'
        ]);
        exit;
    }

    $stmt = $conexion->prepare(
        "INSERT INTO noticias (titulo, descripcion) VALUES (?, ?)"
    );
    $stmt->bind_param("ss", $titulo, $descripcion);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

if ($accion === 'editar') {

    $id = intval($_POST['id'] ?? 0);
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($id <= 0 || $titulo === '' || $descripcion === '') {
        echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
        exit;
    }

    $stmt = $conexion->prepare(
        "UPDATE noticias SET titulo=?, descripcion=? WHERE id_noticia=?"
    );
    $stmt->bind_param("ssi", $titulo, $descripcion, $id);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}

if ($accion === 'borrar') {

    $id = intval($_GET['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['ok' => false, 'error' => 'ID inválido']);
        exit;
    }

    $stmt = $conexion->prepare(
        "DELETE FROM noticias WHERE id_noticia=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['ok' => true]);
    exit;
}



/* =======================
   ACCIÓN NO VÁLIDA
======================= */
echo json_encode([
    'ok' => false,
    'error' => 'Acción no válida'
]);
exit;
