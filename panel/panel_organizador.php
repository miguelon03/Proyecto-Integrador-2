<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'organizador') {
    header("Location: ../index.php");
    exit;
}

require "../backend/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Organizador</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* menú interno organizador */
        .admin-menu {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            justify-content: center;
        }

        .admin-menu button {
            padding: 8px 14px;
            cursor: pointer;
        }

        section {
            display: none;
        }

        section.activa {
            display: block;
        }
    </style>
</head>

<body>

    <header class="ue-header">
        <div class="main-nav">
            <div class="logo">
                <img src="../img/logo_uem.png" alt="Universidad Europea">
            </div>

            <nav class="nav-links">
                <a href="#">Bases del Concurso</a>
                <a href="#">Inscripción</a>
                <a href="#">Ediciones Anteriores</a>
                <a href="eventos.html">Eventos</a>
                <a href="#">Organizador</a>
                <a href="gala.php">Gala</a>
                <a href="../logout.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <main class="content">

        <h1>Panel de Organizador</h1>

        <!-- MENÚ INTERNO -->
        <div class="admin-menu">
            <button onclick="mostrarSeccion('noticias')">Noticias</button>
            <button onclick="mostrarSeccion('eventos')">Eventos</button>
            <button onclick="mostrarSeccion('premios')">Premios</button>
            <button onclick="mostrarSeccion('patrocinadores')">Patrocinadores</button>
            <button onclick="mostrarSeccion('gala')">Gala</button>
        </div>

        <!-- ================= NOTICIAS ================= -->
        <section id="noticias" class="activa">
            <h2>Gestión de Noticias</h2>

            <button onclick="mostrarFormularioNoticia()">➕ Añadir noticia</button>

            <!-- FORMULARIO NUEVA NOTICIA -->
            <form id="formNoticia" style="display:none; margin-top:20px;">
                <div>
                    <label>Título</label><br>
                    <input type="text" name="titulo" required minlength="3">
                    <small class="error"></small>
                </div>

                <div>
                    <label>Descripción</label><br>
                    <textarea name="descripcion" required minlength="5"></textarea>
                    <small class="error"></small>
                </div>

                <button type="submit">Guardar noticia</button>
                <button type="button" onclick="ocultarFormulario()">Cancelar</button>

                <p id="errorGeneral" style="color:red;"></p>
            </form>

            <div id="listaNoticias" style="margin-top:20px;"></div>
        </section>

        <!-- ================= EVENTOS ================= -->
        <section id="eventos">
            <h2>Gestión de Eventos</h2>

            <button onclick="mostrarFormularioEvento()">➕ Añadir evento</button>

            <!-- FORMULARIO EVENTO -->
            <form id="formEvento" style="display:none; margin-top:20px;">
                <div>
                    <label>Título</label><br>
                    <input type="text" name="titulo" required minlength="3">
                </div>

                <div>
                    <label>Descripción</label><br>
                    <textarea name="descripcion" required minlength="5"></textarea>
                </div>

                <div>
                    <label>Fecha inicio</label><br>
                    <input type="date" name="fecha_inicio" required>
                </div>

                <div>
                    <label>Fecha fin</label><br>
                    <input type="date" name="fecha_fin" required>
                </div>

                <button type="submit">Guardar evento</button>
                <button type="button" onclick="ocultarFormularioEvento()">Cancelar</button>

                <p id="errorEvento" style="color:red;"></p>
            </form>

            <div id="listaEventos" style="margin-top:20px;"></div>
        </section>
        <!-- ================= PREMIOS ================= -->
        <section id="premios">
            <h2>Gestión de Premios – Categorías</h2>

            <button onclick="mostrarFormCategoria()">➕ Añadir categoría</button>

            <!-- FORM CATEGORIA -->
            <form id="formCategoria" style="display:none; margin-top:20px;">
                <input type="text" name="nombre" placeholder="Nombre categoría" required>
                <textarea name="descripcion" placeholder="Descripción"></textarea>
                <button type="submit">Guardar categoría</button>
                <button type="button" onclick="ocultarFormCategoria()">Cancelar</button>
                <p id="errorCategoria" style="color:red;"></p>
            </form>

            <div id="listaCategorias" style="margin-top:20px;"></div>
            <hr>

            <h2>Asignar Ganadores</h2>

            <div id="listaGanadores">
                <!-- aquí JS pintará cada categoría con su formulario -->
            </div>


        </section>


        <!-- ================= PATROCINADORES ================= -->
        <section id="patrocinadores">
    <h2>Gestión de Patrocinadores</h2>

    <form id="formPatrocinador" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre patrocinador" required>
        <input type="file" name="logo" accept="image/*" required>
        <button type="submit">Guardar patrocinador</button>
    </form>

    <div id="listaPatrocinadores" style="margin-top:20px;"></div>
</section>


        <!-- ================= GALA ================= -->
        <section id="gala">
    <h2>Gestión de Gala</h2>

    <!-- CAMBIO DE MODO -->
    <div style="margin-bottom:20px;">
        <strong>Modo actual:</strong>
        <span id="modoActual"></span>
        <button onclick="cambiarModo()">Cambiar modo</button>
    </div>

    <!-- ================= PRE-EVENTO ================= -->
    <div id="galaPre">

        <h3>Pre-evento: Secciones</h3>
        <button onclick="mostrarFormSeccion()">➕ Añadir sección</button>

        <form id="formSeccion" style="display:none;margin-top:15px;">
            <input type="text" name="titulo" placeholder="Título" required>
            <input type="time" name="hora" required>
            <input type="text" name="sala" placeholder="Sala" required>
            <textarea name="descripcion" placeholder="Descripción" required></textarea>

            <button type="submit">Guardar sección</button>
            <button type="button" onclick="ocultarFormSeccion()">Cancelar</button>
        </form>

        <div id="listaSecciones"></div>
    </div>

    <!-- ================= POST-EVENTO ================= -->
    <div id="galaPost" style="display:none;">

        <h3>Post-evento</h3>

        <h4>Texto resumen</h4>
        <form id="formResumen">
            <textarea name="texto" rows="5" required></textarea>
            <button type="submit">Guardar resumen</button>
        </form>

        <h4>Galería de imágenes</h4>
        <form id="formImagen" enctype="multipart/form-data">
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Subir imagen</button>
        </form>

        <h4>Edición final</h4>
        <button onclick="guardarEdicion()">➕ Añadir a ediciones anteriores</button>

    </div>

</section>



    </main>

    <script>
        function mostrarSeccion(id) {
            document.querySelectorAll("section").forEach(s => s.classList.remove("activa"));
            document.getElementById(id).classList.add("activa");

            if (id === 'noticias') cargarNoticias();
            if (id === 'eventos') cargarEventos();
            if (id === 'premios') {
                cargarCategorias();
                cargarGanadores();
            }
            if (id === 'gala') cargarModo();
            if (id === 'patrocinadores') cargarPatrocinadores();


        }
    </script>

    <script src="../js/noticias.js">
    </script>
    <script src="../js/eventos.js"></script>
    <script src="../js/premios_categorias.js"></script>
    <script src="../js/premios_ganadores.js"></script>
    <script src="../js/gala_admin.js"></script>
    <script src="../js/patrocinadores.js"></script>

</body>

</html>