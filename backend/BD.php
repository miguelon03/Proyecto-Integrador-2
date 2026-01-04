<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$database = "ProyectoIntegrador";

// Conexión
$conexion = new mysqli($servidor, $usuario, $password);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear base de datos si no existe
$conexion->query("CREATE DATABASE IF NOT EXISTS $database");
$conexion->select_db($database);

// Crear tablas
$conexion->query("
CREATE TABLE IF NOT EXISTS alumnos (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
)");

$conexion->query("
CREATE TABLE IF NOT EXISTS alumni (
    id_alumni INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
)");

$conexion->query("
CREATE TABLE IF NOT EXISTS organizadores (
    id_organizador INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
)");

// Insertar usuarios cifrados
function insertarUsuario($conexion, $tabla, $usuario, $passwordPlano) {
    $hash = password_hash($passwordPlano, PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("
        INSERT INTO $tabla (usuario, contrasena)
        SELECT ?, ?
        WHERE NOT EXISTS (
            SELECT 1 FROM $tabla WHERE usuario = ?
        )
    ");

    $stmt->bind_param("sss", $usuario, $hash, $usuario);
    $stmt->execute();
}

// Usuarios iniciales
insertarUsuario($conexion, "alumnos", "juanjo", "1111");
insertarUsuario($conexion, "alumni", "adrian", "2222");
insertarUsuario($conexion, "organizadores", "miguel", "3333");
