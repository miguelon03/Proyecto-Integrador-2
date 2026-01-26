<?php
session_start();
require "conexion.php";

if ($_SESSION['tipo'] !== 'organizador') {
    exit;
}

$id = $_POST['id_inscripcion'];
$estado = $_POST['estado'];
$motivo = $_POST['motivo'] ?? null;

$stmt = $conexion->prepare("
    UPDATE inscripciones
    SET estado = ?, motivo_rechazo = ?
    WHERE id_inscripcion = ?
");

$stmt->bind_param("ssi", $estado, $motivo, $id);
$stmt->execute();
