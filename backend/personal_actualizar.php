<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../home.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_inscripcion = $_POST['id_inscripcion'];

$stmt = $conexion->prepare("
    UPDATE inscripciones
    SET nombre_responsable = ?, email = ?, dni = ?, expediente = ?, sinopsis = ?
    WHERE id_inscripcion = ? AND id_usuario = ?
");

$stmt->bind_param(
    "ssssiii",
    $_POST['nombre_responsable'],
    $_POST['email'],
    $_POST['dni'],
    $_POST['expediente'],
    $_POST['sinopsis'],
    $id_inscripcion,
    $id_usuario
);

$stmt->execute();

header("Location: ../panel/personal.php");
exit;
