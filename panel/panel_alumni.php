<?php
session_start();
if ($_SESSION['tipo'] !== 'alumni') {
    header("Location: ../index.php");
    exit;
}
?>

<h1>Panel Alumni</h1>
