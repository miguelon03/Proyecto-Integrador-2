<?php
session_start();
require "conexion.php";

if ($_SESSION['tipo'] !== 'organizador') {
  echo json_encode(['ok'=>false,'error'=>'No autorizado']);
  exit;
}

$accion = $_GET['accion'] ?? '';

if ($accion === 'listar') {
  $res = $conexion->query("SELECT * FROM premios");
  echo json_encode(['premios'=>$res->fetch_all(MYSQLI_ASSOC)]);
  exit;
}

if ($accion === 'crear') {
  $stmt = $conexion->prepare("INSERT INTO premios (nombre, descripcion) VALUES (?,?)");
  $stmt->bind_param("ss", $_POST['nombre'], $_POST['descripcion']);
  $stmt->execute();
  echo json_encode(['ok'=>true]);
  exit;
}

if ($accion === 'asignar') {
  $stmt = $conexion->prepare("
    INSERT INTO premios_ganadores (id_premio, id_inscripcion)
    VALUES (?, ?)
  ");
  $stmt->bind_param("ii", $_POST['id_premio'], $_POST['id_inscripcion']);
  $stmt->execute();

  // Cambiar estado a NOMINADO
  $conexion->query("
    UPDATE inscripciones
    SET estado='NOMINADO'
    WHERE id_inscripcion=".(int)$_POST['id_inscripcion']
  );

  echo json_encode(['ok'=>true]);
  exit;
}
