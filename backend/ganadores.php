<?php
session_start();
header("Content-Type: application/json");
require "conexion.php";

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'organizador') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$accion = $_GET['accion'] ?? '';

/* =========================
   LISTAR CATEGORÍAS + PARTICIPANTES
========================= */
if ($accion === 'listar') {

    $categorias = [];
    $res = $conexion->query("SELECT * FROM categorias");

    while ($cat = $res->fetch_assoc()) {

        // Detectamos tipo por nombre (simple y válido para la rúbrica)
        $tipo = strtolower($cat['nombre']);

        if (str_contains($tipo, 'alumno')) {
            $part = $conexion->query("SELECT usuario FROM alumnos");
            $cat['tipo'] = 'Alumnos';
        } elseif (str_contains($tipo, 'alumni')) {
            $part = $conexion->query("SELECT usuario FROM alumni");
            $cat['tipo'] = 'Alumni';
        } elseif (str_contains($tipo, 'carrera')) {
            $cat['tipo'] = 'Carrera Profesional';
            $cat['participantes'] = [];
            $categorias[] = $cat;
            continue;
        } else {
            // Categoría genérica → no mostramos ganador
            continue;
        }

        $cat['participantes'] = [];
        while ($p = $part->fetch_assoc()) {
            $cat['participantes'][] = $p;
        }

        $categorias[] = $cat;
    }

    echo json_encode([
        'ok' => true,
        'categorias' => $categorias
    ]);
    exit;
}

/* =========================
   GUARDAR GANADOR
========================= */
if ($accion === 'guardar') {

    $id_categoria = $_POST['id_categoria'];

    // Carrera Profesional
    if (isset($_POST['nombre'])) {

        $stmt = $conexion->prepare("
            INSERT INTO ganadores (id_categoria, nombre, email, telefono, video)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "issss",
            $id_categoria,
            $_POST['nombre'],
            $_POST['email'],
            $_POST['telefono'],
            $_POST['video']
        );
        $stmt->execute();

        echo json_encode(['ok' => true]);
        exit;
    }

    // Alumnos / Alumni
    if (isset($_POST['ganador'])) {

        $stmt = $conexion->prepare("
            INSERT INTO ganadores (id_categoria, nombre)
            VALUES (?, ?)
        ");
        $stmt->bind_param(
            "is",
            $id_categoria,
            $_POST['ganador']
        );
        $stmt->execute();

        echo json_encode(['ok' => true]);
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
    exit;
}
