<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$database = "ProyectoIntegrador";

/* =======================
   CONEXIÓN
======================= */
$conexion = new mysqli($servidor, $usuario, $password);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

/* =======================
   BASE DE DATOS
======================= */
$conexion->query("CREATE DATABASE IF NOT EXISTS $database");
$conexion->select_db($database);

/* =======================
   CREACIÓN DE TABLAS (MULTI_QUERY)
======================= */
$sql = "

CREATE TABLE IF NOT EXISTS alumnos (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS alumni (
    id_alumni INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS organizadores (
    id_organizador INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS noticias (
    id_noticia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS premios (
    id_premio INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    premio_fisico BOOLEAN DEFAULT 0,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ganadores (
    id_ganador INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nombre VARCHAR(150),
    email VARCHAR(150),
    telefono VARCHAR(50),
    video VARCHAR(255),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS patrocinadores (
    id_patrocinador INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    logo VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS gala_secciones (
    id_seccion INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    hora TIME NOT NULL,
    sala VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS ediciones (
    id_edicion INT AUTO_INCREMENT PRIMARY KEY,
    anio INT NOT NULL,
    numero_participantes INT,
    ganador_alumnos VARCHAR(150),
    ganador_alumni VARCHAR(150),
    ganador_carrera VARCHAR(150),
    corto_alumnos VARCHAR(255),
    corto_alumni VARCHAR(255)
);

";

if (!$conexion->multi_query($sql)) {
    die("Error al crear tablas: " . $conexion->error);
}

// Limpiar resultados pendientes del multi_query
while ($conexion->next_result()) {;}

/* =======================
   FUNCIÓN PARA INSERTAR USUARIOS (HASH)
======================= */
function insertarUsuario($conexion, $tabla, $usuario, $passwordPlano) {
    $hash = password_hash($passwordPlano, PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("
        INSERT INTO $tabla (usuario, contrasena)
        SELECT ?, ?
        WHERE NOT EXISTS (
            SELECT 1 FROM $tabla WHERE usuario = ?
        )
    ");

    if ($stmt) {
        $stmt->bind_param("sss", $usuario, $hash, $usuario);
        $stmt->execute();
        $stmt->close();
    }
}

/* =======================
   USUARIOS INICIALES
======================= */
insertarUsuario($conexion, "alumnos", "juanjo", "1111");
insertarUsuario($conexion, "alumni", "adrian", "2222");
insertarUsuario($conexion, "organizadores", "miguel", "3333");
