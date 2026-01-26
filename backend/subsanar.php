<?php
session_start();
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$id = $_POST['id_inscripcion'];
$msg = $_POST['mensaje'];

$stmt = $conexion->prepare("
  UPDATE inscripciones
  SET mensaje_subsanacion=?, estado='PENDIENTE'
  WHERE id_inscripcion=? AND id_usuario=?
");
$stmt->bind_param("sii", $msg, $id, $id_usuario);
$stmt->execute();

header("Location: ../panel/personal.php");
