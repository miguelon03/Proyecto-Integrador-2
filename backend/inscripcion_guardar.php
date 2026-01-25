<?php
session_start();
require "conexion.php";

// Usuario provisional
$id_usuario = 1;

// Crear carpeta si no existe
$carpeta = "../uploads/inscripciones/";
if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

function subirArchivo($campo)
{
    if (!isset($_FILES[$campo])) {
        die("Falta el archivo: $campo");
    }

    $nombre = time() . "_" . basename($_FILES[$campo]['name']);
    $rutaServidor = "../uploads/inscripciones/" . $nombre;
    $rutaBD = "uploads/inscripciones/" . $nombre;

    if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaServidor)) {
        die("Error al subir $campo");
    }

    return $rutaBD;
}

// Subidas
$ficha = subirArchivo("ficha");
$cartel = subirArchivo("cartel");
$expediente = subirArchivo("expediente");

// INSERT (VIDEO ES LINK)
$stmt = $conexion->prepare("
    INSERT INTO inscripciones 
    (id_usuario, ficha, cartel, sinopsis, nombre_responsable, email, dni, expediente, video)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssssss",
    $id_usuario,
    $ficha,
    $cartel,
    $_POST['sinopsis'],
    $_POST['nombre_responsable'],
    $_POST['email'],
    $_POST['dni'],
    $expediente,
    $_POST['video']
);

if (!$stmt->execute()) {
    die("Error en la inserción: " . $stmt->error);
}
$_SESSION['usuario'] = true; // marca sesión activa
header("Location: ../home.php");
exit;

exit;
