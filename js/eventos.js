let editandoEvento = null;

function mostrarFormularioEvento() {
    document.getElementById("formEvento").style.display = "block";
}

function ocultarFormularioEvento() {
    document.getElementById("formEvento").style.display = "none";
    document.getElementById("formEvento").reset();
    document.getElementById("errorEvento").innerText = "";
    editandoEvento = null;
}

function cargarEventos() {
    fetch("../backend/eventos.php?accion=listar")
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById("listaEventos");
            cont.innerHTML = "";

            if (!data.ok || data.eventos.length === 0) {
                cont.innerHTML = "<p>No hay eventos</p>";
                return;
            }

            data.eventos.forEach(e => {
                const div = document.createElement("div");
                div.className = "news-card";
                div.innerHTML = `
                    <h3>${e.titulo}</h3>
                    <p>${e.descripcion}</p>
                    <small>${e.fecha} · ${e.hora}</small><br>
                    <button onclick="editarEvento(${e.id_evento}, '${escapeHtml(e.titulo)}', '${escapeHtml(e.descripcion)}', '${e.fecha}', '${e.hora}')">Editar</button>
                    <button onclick="borrarEvento(${e.id_evento})">Borrar</button>
                `;
                cont.appendChild(div);
            });
        });
}

function editarEvento(id, titulo, descripcion, fecha, hora) {
    editandoEvento = id;
    mostrarFormularioEvento();

    const form = document.getElementById("formEvento");
    form.titulo.value = titulo;
    form.descripcion.value = descripcion;
    form.fecha.value = fecha;
    form.hora.value = hora;
}

function borrarEvento(id) {
    if (!confirm("¿Borrar este evento?")) return;

    fetch(`../backend/eventos.php?accion=borrar&id=${id}`, { method: "POST" })
        .then(res => res.json())
        .then(data => {
            if (data.ok) cargarEventos();
        });
}
document.getElementById("formEvento").addEventListener("submit", function(e) {
    e.preventDefault();

    const error = document.getElementById("errorEvento");
    error.innerText = "";

    const titulo = this.querySelector('[name="titulo"]').value;
    const descripcion = this.querySelector('[name="descripcion"]').value;
    const fecha = this.querySelector('[name="fecha"]').value;
    const hora = this.querySelector('[name="hora"]').value;

    if (!titulo || !descripcion || !fecha || !hora) {
        error.innerText = "Todos los campos son obligatorios";
        return;
    }

    const formData = new FormData(this);
    const accion = editandoEvento ? "editar" : "crear";
    if (editandoEvento) formData.append("id", editandoEvento);

    fetch(`../backend/eventos.php?accion=${accion}`, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            ocultarFormularioEvento();
            cargarEventos();
        } else {
            error.innerText = data.error || "Error al guardar el evento";
        }
    });
});


function escapeHtml(text) {
    return text.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
