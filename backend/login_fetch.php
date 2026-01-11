<?php
session_start();
header('Content-Type: application/json');

require "conexion.php";

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

$stmt = $conexion->prepare("SELECT contrasena FROM $tabla WHERE usuario=?");
if (!$stmt) {
    echo json_encode(['ok' => false, 'error' => 'Error en la consulta']);
    exit;
}

$stmt->bind_param("s", $usuario);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows === 1) {
    $row = $res->fetch_assoc();

    if (password_verify($contrasena, $row['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = $tipo;

        echo json_encode([
            'ok' => true,
            'redirect' => $panel
        ]);
        exit;
    }
}

echo json_encode([
    'ok' => false,
    'error' => 'Usuario o contraseña incorrectos'
]);
exit;
