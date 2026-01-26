<?php
$tipo = $_GET['tipo'] ?? '';
if (!in_array($tipo, ['participante', 'organizador'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="../css/login.css">

</head>

<body>
    <div class="login-container">
        <h2>Login <?= ucfirst($tipo) ?></h2>

        <form id="loginForm">
            <div class="campo">
                <input type="text" name="usuario" placeholder="Usuario">
                <small class="error"></small>
            </div>

            <div class="campo">
                <input type="password" name="contrasena" placeholder="Contraseña">
                <small class="error"></small>
            </div>

            <input type="hidden" name="tipo" value="<?= $tipo ?>">
            <button type="submit">Entrar</button>
        </form>

        <p id="mensaje"></p>

    </div>

   <script>
document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let valido = true;
    const campos = this.querySelectorAll(".campo");

    campos.forEach(campo => {
        const input = campo.querySelector("input");
        const error = campo.querySelector(".error");

        if (!input.value.trim()) {
            error.textContent = "Campo obligatorio";
            valido = false;
        } else {
            error.textContent = "";
        }
    });

    if (!valido) return;

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