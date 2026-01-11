<?php
session_start();
require "conexion.php";
header("Content-Type: application/json");

if ($_SESSION['tipo'] !== 'organizador') {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$accion = $_GET['accion'] ?? '';

if ($accion === 'listarCategorias') {
    $res = $conexion->query("SELECT * FROM categorias");
    $data = [];
    while ($f = $res->fetch_assoc()) $data[] = $f;
    echo json_encode(['categorias' => $data]);
}

/* CREAR */
if ($accion === 'crearCategoria') {
    $stmt = $conexion->prepare(
        "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)"
    );
    $stmt->bind_param("ss", $_POST['nombre'], $_POST['descripcion']);
    $stmt->execute();
}

/* EDITAR */
if ($accion === 'editarCategoria') {
    $stmt = $conexion->prepare(
        "UPDATE categorias SET nombre=? WHERE id_categoria=?"
    );
    $stmt->bind_param("si", $_POST['nombre'], $_POST['id']);
    $stmt->execute();
}

/* BORRAR */
if ($accion === 'borrarCategoria') {
    $stmt = $conexion->prepare(
        "DELETE FROM categorias WHERE id_categoria=?"
    );
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
}
