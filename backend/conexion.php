<?php
$conexion = new mysqli("localhost", "root", "", "ProyectoIntegrador");
if ($conexion->connect_error) {
    die("Error de conexión");
}
