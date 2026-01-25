<?php
session_start();
require "../backend/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inscripción</title>
</head>

<body>
    <style>
        .form-container {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #222;
        }

        .inscripcion-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0077cc;
        }

        .btn-submit {
            margin-top: 15px;
            padding: 12px;
            background-color: #0077cc;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #005fa3;
        }
    </style>
    <div class="form-container">
        <h1>Inscripción al concurso</h1>

        <form class="inscripcion-form" action="../backend/inscripcion_guardar.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Ficha técnico-artística</label>
                <input type="file" name="ficha" required>
            </div>

            <div class="form-group">
                <label>Cartel</label>
                <input type="file" name="cartel" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>Sinopsis</label>
                <textarea name="sinopsis" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label>Nombre de la persona responsable</label>
                <input type="text" name="nombre_responsable" required>
            </div>

            <div class="form-group">
                <label>Email de contacto</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>DNI</label>
                <input type="text" name="dni" required>
            </div>

            <div class="form-group">
                <label>Expediente</label>
                <input type="file" name="expediente" required>
            </div>

            <div class="form-group">
                <label>Vídeo (enlace)</label>
                <input type="url" name="video" placeholder="https://youtube.com/..." required>
            </div>


            <button type="submit" class="btn-submit">Enviar inscripción</button>
        </form>
    </div>

</body>

</html>