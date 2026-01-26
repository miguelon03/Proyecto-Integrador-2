<?php
session_start();
header('Content-Type: application/json');

require "conexion.php";

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$tipo = $_POST['tipo'] ?? '';

$mapa = [
    'participante' => [
        'tabla' => 'participantes',
        'id'    => 'id_usuario',
        'panel' => '../home.php'
    ],
    'organizador' => [
        'tabla' => 'organizadores',
        'id'    => 'id_organizador',
        'panel' => '../panel/panel_organizador.php'
    ]
];

if (!isset($mapa[$tipo])) {
    echo json_encode(['ok' => false, 'error' => 'Tipo no válido']);
    exit;
}

$tabla = $mapa[$tipo]['tabla'];
$idCampo = $mapa[$tipo]['id'];
$panel = $mapa[$tipo]['panel'];

// ⚠️ IMPORTANTE: traemos también el ID
$stmt = $conexion->prepare("
    SELECT $idCampo, contrasena
    FROM $tabla
    WHERE usuario = ?
");

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

        // 🔐 SESIÓN CORRECTA
        $_SESSION['tipo'] = $tipo;
        $_SESSION['usuario'] = $usuario;

        // 👇 CLAVE PARA PERFIL / INSCRIPCIONES
        if ($tipo === 'participante') {
            $_SESSION['id_usuario'] = $row[$idCampo];
        }

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
