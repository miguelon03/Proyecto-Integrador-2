<?php
header('Content-Type: application/json');
require "conexion.php";

$res = $conexion->query("
  SELECT id_evento, titulo, descripcion, fecha_inicio, fecha_fin
  FROM eventos
");

$eventos = [];

while ($e = $res->fetch_assoc()) {
    $eventos[] = [
        'id' => $e['id_evento'],
        'title' => $e['titulo'],
        'start' => $e['fecha_inicio'],
        'end' => date('Y-m-d', strtotime($e['fecha_fin'].' +1 day')),
        'descripcion' => $e['descripcion']
    ];
}

echo json_encode($eventos);
exit;
