<?php
$tipo = $_GET['tipo'] ?? '';
if (!in_array($tipo, ['alumno', 'alumni', 'organizador'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login <?= ucfirst($tipo) ?></title>
</head>
<body>

<h2>Login <?= ucfirst($tipo) ?></h2>

<form id="loginForm">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <input type="hidden" name="tipo" value="<?= $tipo ?>">
    <button type="submit">Entrar</button>
</form>

<p id="mensaje" style="color:red;"></p>

<script>
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../backend/login_fetch.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            window.location.href = data.redirect;
        } else {
            document.getElementById("mensaje").innerText = data.error;
        }
    })
    .catch(() => {
        document.getElementById("mensaje").innerText = "Error de conexión";
    });
});
</script>

</body>
</html>
