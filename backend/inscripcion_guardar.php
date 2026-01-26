<?php
session_start();
require "conexion.php";

/* ===============================
   1️⃣ DETERMINAR USUARIO
=============================== */

// Si ya existe sesión → nueva candidatura
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = null; // primera inscripción
}

/* ===============================
   2️⃣ LÍMITE DE 2 CANDIDATURAS
=============================== */

if ($id_usuario !== null) {
    $res = $conexion->query("
        SELECT COUNT(*) AS total
        FROM inscripciones
        WHERE id_usuario = $id_usuario
    ");

    if ($res->fetch_assoc()['total'] >= 2) {
        die("Máximo de candidaturas alcanzado");
    }
}

/* ===============================
   3️⃣ SUBIDA DE ARCHIVOS
=============================== */

$dir = "../uploads/inscripciones/";
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

function subir($campo) {
    $nombre = time() . "_" . basename($_FILES[$campo]['name']);
    move_uploaded_file($_FILES[$campo]['tmp_name'], "../uploads/inscripciones/$nombre");
    return "uploads/inscripciones/$nombre";
}

$ficha  = subir("ficha");
$cartel = subir("cartel");

/* ===============================
   4️⃣ PRIMERA INSCRIPCIÓN → CREAR USUARIO
=============================== */

if ($id_usuario === null) {

    $hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $stmtUser = $conexion->prepare("
        INSERT INTO participantes (usuario, contrasena)
        VALUES (?, ?)
    ");
    $stmtUser->bind_param("ss", $_POST['nombre_responsable'], $hash);
    $stmtUser->execute();

    // Guardar id real del usuario
    $id_usuario = $stmtUser->insert_id;
    $_SESSION['id_usuario'] = $id_usuario;
}

/* ===============================
   5️⃣ REUTILIZAR DATOS SI ES NUEVA CANDIDATURA
=============================== */

if (!isset($_POST['email'])) {
    $res = $conexion->query("
        SELECT nombre_responsable, email, dni, expediente
        FROM inscripciones
        WHERE id_usuario = $id_usuario
        ORDER BY fecha DESC
        LIMIT 1
    ");
    $datos = $res->fetch_assoc();

    $_POST = array_merge($datos, $_POST);
}

/* ===============================
   6️⃣ INSERTAR INSCRIPCIÓN
=============================== */

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
    $_POST['expediente'],
    $_POST['video']
);

$stmt->execute();

/* ===============================
   7️⃣ REDIRECCIÓN FINAL
=============================== */

$_SESSION['usuario'] = true;
header("Location: ../home.php");
exit;
