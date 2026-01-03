<?php
session_start();
if ($_SESSION['tipo'] !== 'organizador') {
    header("Location: ../index.php");
    exit;
}
?>

<h1>Panel Organizador</h1>
