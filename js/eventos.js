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
                    <small>${e.fecha_inicio} → ${e.fecha_fin}</small><br>
                    <button onclick="editarEvento(${e.id_evento}, '${escapeHtml(e.titulo)}', '${escapeHtml(e.descripcion)}', '${e.fecha_inicio}', '${e.fecha_fin}')">
                        Editar
                    </button>
                    <button onclick="borrarEvento(${e.id_evento})">
                        Borrar
                    </button>
                `;
                cont.appendChild(div);
            });
        });
}

function editarEvento(id, titulo, descripcion, inicio, fin) {
    editandoEvento = id;
    mostrarFormularioEvento();

    const form = document.getElementById("formEvento");
    form.titulo.value = titulo;
    form.descripcion.value = descripcion;
    form.fecha_inicio.value = inicio;
    form.fecha_fin.value = fin;
}

function borrarEvento(id) {
    if (!confirm("¿Borrar este evento?")) return;

    fetch(`../backend/eventos.php?accion=borrar&id=${id}`, { method: "POST" })
        .then(res => res.json())
        .then(data => {
            if (data.ok) cargarEventos();
            else alert(data.error);
        });
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formEvento");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const error = document.getElementById("errorEvento");

        error.innerText = "";

        const inicio = this.fecha_inicio.value;
        const fin = this.fecha_fin.value;
        const hoy = new Date().toISOString().split('T')[0];
        const limite = '2026-12-21';

        if (inicio < hoy || fin > limite || inicio > fin) {
            error.innerText = "Fechas fuera de rango permitido";
            return;
        }

        const accion = editandoEvento ? 'editar' : 'crear';
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
                error.innerText = data.error;
            }
        });
    });
});
function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/\\/g, '\\\\')
        .replace(/'/g, "\\'")
        .replace(/"/g, '&quot;')
        .replace(/\n/g, '\\n');
}
