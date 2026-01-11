<?php
header('Content-Type: application/json');
require "conexion.php";

$mes = intval($_GET['mes'] ?? date('n'));
$anyo = intval($_GET['anyo'] ?? date('Y'));

/*
   Devuelve los días del mes que tienen eventos
   Formato: YYYY-MM-DD
*/
$sql = "
    SELECT DISTINCT fecha_inicio AS dia
    FROM eventos
    WHERE MONTH(fecha_inicio) = ? AND YEAR(fecha_inicio) = ?
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $mes, $anyo);
$stmt->execute();

$res = $stmt->get_result();
$dias = [];

while ($fila = $res->fetch_assoc()) {
    $dias[] = $fila['dia'];
}

echo json_encode($dias);
