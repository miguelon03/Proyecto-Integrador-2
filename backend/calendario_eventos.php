<?php
require "conexion.php";

$res = $conexion->query("SELECT * FROM eventos");

$eventos = [];

while ($e = $res->fetch_assoc()) {
    $eventos[] = [
        'title' => $e['titulo'] . ' (' . substr($e['hora'],0,5) . ')',
        'start' => $e['fecha'],
        'descripcion' => $e['descripcion'],
        'color' => '#c40000'
    ];
}

echo json_encode($eventos);
