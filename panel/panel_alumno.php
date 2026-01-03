<?php
session_start();
if ($_SESSION['tipo'] !== 'alumno') {
    header("Location: ../index.php");
    exit;
}
?>

<h1>Panel Alumno</h1>
