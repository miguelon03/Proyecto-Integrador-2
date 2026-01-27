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
    <title>Panel Organizador</title>
    <link rel="stylesheet" href="../css/panel_organizador.css">

    <style>
        .campo {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-size: 12px;
            min-height: 14px;
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

                <a href="#">Noticias</a>
                <a href="eventos.html">Eventos</a>
                <a href="gala.php">Gala</a>
                <a href="../logout.php">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main class="content">

        <h1>Panel de Organizador</h1>

        <div class="admin-menu">
            <button onclick="mostrarSeccion('noticias')">Noticias</button>
            <button onclick="mostrarSeccion('eventos')">Eventos</button>
            <button onclick="mostrarSeccion('premios')">Premios</button>
            <button onclick="mostrarSeccion('patrocinadores')">Patrocinadores</button>
            <button onclick="mostrarSeccion('gala')">Gala</button>
            <button onclick="mostrarSeccion('candidaturas')">Candidaturas</button>

        </div>

        <!-- ================= NOTICIAS ================= -->
        <section id="noticias" class="activa">
            <h2>Gestión de Noticias</h2>

            <button onclick="mostrarFormularioNoticia()">➕ Añadir noticia</button>

            <form id="formNoticia" style="display:none;margin-top:20px;">
                <div class="campo">
                    <label>Título</label>
                    <input type="text" name="titulo">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Descripción</label>
                    <textarea name="descripcion"></textarea>
                    <small class="error"></small>
                </div>

                <button type="submit">Guardar noticia</button>
                <button type="button" onclick="ocultarFormulario()">Cancelar</button>
                <p id="errorGeneral" class="error"></p>

            </form>

            <div id="listaNoticias"></div>
        </section>

        <!-- ================= EVENTOS ================= -->
        <section id="eventos">
            <h2>Gestión de Eventos</h2>

            <button onclick="mostrarFormularioEvento()">➕ Añadir evento</button>

            <form id="formEvento" style="display:none;margin-top:20px;">
                <div class="campo">
                    <label>Título</label>
                    <input type="text" name="titulo">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Descripción</label>
                    <textarea name="descripcion"></textarea>
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Fecha</label>
                    <input type="date" name="fecha">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <label>Hora</label>
                    <input type="time" name="hora">
                    <small class="error"></small>
                </div>

                <button type="submit">Guardar evento</button>
                <button type="button" onclick="ocultarFormularioEvento()">Cancelar</button>
                <p id="errorEvento" class="error"></p>
            </form>


            <div id="listaEventos"></div>
        </section>

        <!-- ================= PREMIOS ================= -->
        <section id="premios">
            <h3>Crear premio</h3>

            <form id="formPremio">
                <div class="campo">
                    <input type="text" name="nombre" placeholder="Nombre del premio">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <textarea name="descripcion" placeholder="Descripción"></textarea>
                    <small class="error"></small>
                </div>

                <button type="submit">Guardar premio</button>
            </form>

            <div id="listaPremios"></div>
            <h3>Asignar ganador</h3>

            <form id="formGanador">
                <div class="campo">
                    <label>Premio</label>
                    <select name="id_premio"></select>
                </div>

                <div class="campo">
                    <label>Candidatura</label>
                    <select name="id_inscripcion"></select>
                </div>

                <button type="submit">Asignar ganador</button>
            </form>

            <div id="resultadoGanador"></div>

        </section>

        <!-- ================= PATROCINADORES ================= -->
        <section id="patrocinadores">
            <h2>Gestión de Patrocinadores</h2>

            <form id="formPatrocinador" enctype="multipart/form-data">
                <div class="campo">
                    <input type="text" name="nombre" placeholder="Nombre patrocinador">
                    <small class="error"></small>
                </div>

                <div class="campo">
                    <input type="file" name="logo">
                    <small class="error"></small>
                </div>

                <button type="submit">Guardar patrocinador</button>
                <p id="errorGeneral" class="error"></p>

            </form>

            <div id="listaPatrocinadores"></div>
        </section>

        <!-- ================= GALA ================= -->
        <section id="gala">
            <h2>Gestión de Gala</h2> <!-- CAMBIO DE MODO -->
            <div style="margin-bottom:20px;"> <strong>Modo actual:</strong> <span id="modoActual"></span> <button onclick="cambiarModo()">Cambiar modo</button> </div> <!-- ================= PRE-EVENTO ================= -->
            <div id="galaPre">
                <h3>Pre-evento: Secciones</h3> <button onclick="mostrarFormSeccion()">➕ Añadir sección</button>
                <form id="formSeccion" style="display:none;margin-top:15px;"> <input type="text" name="titulo" placeholder="Título" required> <input type="time" name="hora" required> <input type="text" name="sala" placeholder="Sala" required> <textarea name="descripcion" placeholder="Descripción" required></textarea> <button type="submit">Guardar sección</button> <button type="button" onclick="ocultarFormSeccion()">Cancelar</button> </form>
                <div id="listaSecciones"></div>
            </div> <!-- ================= POST-EVENTO ================= -->
            <div id="galaPost" style="display:none;">
                <h3>Post-evento</h3>
                <h4>Texto resumen</h4>
                <form id="formResumen"> <textarea name="texto" rows="5" required></textarea> <button type="submit">Guardar resumen</button> </form>
                <h4>Galería de imágenes</h4>
                <form id="formImagen" enctype="multipart/form-data"> <input type="file" name="imagen" accept="image/*" required> <button type="submit">Subir imagen</button> </form>
                <h4>Edición final</h4> <button onclick="guardarEdicion()">Añadir a ediciones anteriores</button>
            </div>
        </section>
        <!-- ================= CANDIDATURAS ================= -->
        <section id="candidaturas">
            <h2>Gestión de Candidaturas</h2>
            <div id="listaCandidaturas"></div>
        </section>


    </main>

    <script>
        function mostrarSeccion(id) {
            document.querySelectorAll("section").forEach(s => s.classList.remove("activa"));
            document.getElementById(id).classList.add("activa");

            if (id === 'noticias') cargarNoticias();
            if (id === 'eventos') cargarEventos();
            if (id === 'premios') {
                cargarPremios();
                cargarCandidaturas();
            }

            if (id === 'patrocinadores') cargarPatrocinadores();
            if (id === 'gala') cargarModo();
            if (id === 'candidaturas') cargarCandidaturas();
        }



        /* VALIDACIÓN GENÉRICA */
        function validarFormulario(form) {
            let ok = true;
            form.querySelectorAll("input, textarea").forEach(campo => {
                const error = campo.nextElementSibling;
                if (campo.value.trim() === "") {
                    error.textContent = "Campo obligatorio";
                    ok = false;
                } else {
                    error.textContent = "";
                }
            });
            return ok;
        }

        /* ENGANCHE A FORMULARIOS */
        document.querySelectorAll("form.validable").forEach(f => {
            f.addEventListener("submit", function(e) {
                if (!validarFormulario(this)) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <script src="../js/noticias.js"></script>
    <script src="../js/eventos.js"></script>
    <script src="../js/premios.js"></script>
    <script src="../js/gala_admin.js"></script>
    <script src="../js/patrocinadores.js"></script>
    <script src="../js/candidaturas.js"></script>


</body>

</html>