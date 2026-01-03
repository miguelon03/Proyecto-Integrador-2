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

// SQL correcto
$sql = "

CREATE TABLE IF NOT EXISTS alumnos (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS alumni (
    id_alumni INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS organizadores (
    id_organizador INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(100) NOT NULL
);

INSERT INTO alumnos (usuario, contrasena)
SELECT 'juanjo', '1111'
WHERE NOT EXISTS (SELECT 1 FROM alumnos WHERE usuario='juanjo');

INSERT INTO alumni (usuario, contrasena)
SELECT 'adrian', '2222'
WHERE NOT EXISTS (SELECT 1 FROM alumni WHERE usuario='adrian');

INSERT INTO organizadores (usuario, contrasena)
SELECT 'miguel', '3333'
WHERE NOT EXISTS (SELECT 1 FROM organizadores WHERE usuario='miguel');

";

if (!$conexion->multi_query($sql)) {
    die("Error en SQL: " . $conexion->error);
}

while ($conexion->next_result()) {;}

?>
