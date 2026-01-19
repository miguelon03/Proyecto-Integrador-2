<?php
require "conexion.php";

$accion = $_GET['accion'] ?? '';

/* ================= LISTAR ================= */
if ($accion === 'listar') {
    $res = $conexion->query("SELECT * FROM patrocinadores");
    $datos = [];
    while ($fila = $res->fetch_assoc()) {
        $datos[] = $fila;
    }
    echo json_encode($datos);
    exit;
}

/* ================= AÑADIR ================= */
if ($accion === 'crear') {
    $nombre = $_POST['nombre'];

    $logo = $_FILES['logo']['name'];
    $ruta = "../uploads/patrocinadores/" . time() . "_" . $logo;
    move_uploaded_file($_FILES['logo']['tmp_name'], $ruta);

    $stmt = $conexion->prepare(
        "INSERT INTO patrocinadores (nombre, logo) VALUES (?, ?)"
    );
    $stmt->bind_param("ss", $nombre, $ruta);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    exit;
}

/* ================= EDITAR ================= */
if ($accion === 'editar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    if (!empty($_FILES['logo']['name'])) {
        $logo = $_FILES['logo']['name'];
        $nombreFinal = time() . "_" . $logo;
        $rutaBD = "uploads/patrocinadores/" . $nombreFinal;
        $rutaServidor = "../uploads/patrocinadores/" . $nombreFinal;

        move_uploaded_file($_FILES['logo']['tmp_name'], $rutaServidor);

        $stmt = $conexion->prepare(
            "UPDATE patrocinadores SET nombre=?, logo=? WHERE id_patrocinador=?"
        );
        $stmt->bind_param("ssi", $nombre, $rutaBD,$id);

    } else {
        $stmt = $conexion->prepare(
            "UPDATE patrocinadores SET nombre=? WHERE id_patrocinador=?"
        );
        $stmt->bind_param("si", $nombre, $id);
    }

    $stmt->execute();
    echo json_encode(["ok" => true]);
    exit;
}

/* ================= ELIMINAR ================= */
if ($accion === 'eliminar') {
    $id = $_POST['id'];
    $conexion->query(
        "DELETE FROM patrocinadores WHERE id_patrocinador=$id"
    );
    echo json_encode(["ok" => true]);
}
