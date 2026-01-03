<?php
session_start();
require "BD.php";

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$tipo = $_POST['tipo'] ?? '';

$mapa = [
    'alumno' => [
        'tabla' => 'alumnos',
        'panel' => '../panel/panel_alumno.php'
    ],
    'alumni' => [
        'tabla' => 'alumni',
        'panel' => '../panel/panel_alumni.php'
    ],
    'organizador' => [
        'tabla' => 'organizadores',
        'panel' => '../panel/panel_organizador.php'
    ]
];

if (!isset($mapa[$tipo])) {
    echo json_encode(['ok' => false, 'error' => 'Tipo no válido']);
    exit;
}

$tabla = $mapa[$tipo]['tabla'];
$panel = $mapa[$tipo]['panel'];

$stmt = $conexion->prepare(
    "SELECT * FROM $tabla WHERE usuario=? AND contrasena=?"
);
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['tipo'] = $tipo;

    echo json_encode([
        'ok' => true,
        'redirect' => $panel
    ]);
} else {
    echo json_encode([
        'ok' => false,
        'error' => 'Usuario o contraseña incorrectos'
    ]);
}
