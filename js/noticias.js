function cargarNoticias() {
    fetch("../backend/noticias.php?accion=listar")
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById("listaNoticias");
            cont.innerHTML = "";

            if (!data.ok || data.noticias.length === 0) {
                cont.innerHTML = "<p>No hay noticias</p>";
                return;
            }

            data.noticias.forEach(n => {
                const div = document.createElement("div");
                div.className = "news-card";
                div.innerHTML = `
                    <div class="news-text">
                        <h3>${n.titulo}</h3>
                        <p>${n.descripcion}</p>
                        <button onclick="editarNoticia(${n.id_noticia}, '${escapeHtml(n.titulo)}', '${escapeHtml(n.descripcion)}')">
                            Editar
                        </button>
                        <button onclick="borrarNoticia(${n.id_noticia})">
                            Borrar
                        </button>

                    </div>
                `;
                cont.appendChild(div);
            });
        });
}
function mostrarFormularioNoticia() {
    document.getElementById("formNoticia").style.display = "block";
}

function ocultarFormulario() {
    document.getElementById("formNoticia").style.display = "none";
    document.getElementById("formNoticia").reset();
    document.getElementById("errorGeneral").innerText = "";
}

// Cargar noticias al entrar
cargarNoticias();
document.getElementById("formNoticia").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const errorGeneral = document.getElementById("errorGeneral");

    errorGeneral.innerText = "";

    if (!this.titulo.value.trim() || !this.descripcion.value.trim()) {
        errorGeneral.innerText = "No se pueden guardar noticias vacías";
        return;
    }

    let accion = editandoId ? 'editar' : 'crear';
    if (editandoId) {
        formData.append("id", editandoId);
    }

    fetch(`../backend/noticias.php?accion=${accion}`, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            ocultarFormulario();
            editandoId = null;
            cargarNoticias();
        } else {
            errorGeneral.innerText = data.error;
        }
    })
    .catch(() => {
        errorGeneral.innerText = "Error al guardar la noticia";
    });
});

function escapeHtml(text) {
    return text.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

let editandoId = null;

function editarNoticia(id, titulo, descripcion) {
    editandoId = id;

    const form = document.getElementById("formNoticia");
    form.style.display = "block";

    form.titulo.value = titulo;
    form.descripcion.value = descripcion;
}

function borrarNoticia(id) {
    if (!confirm("¿Seguro que quieres borrar esta noticia?")) return;

    fetch(`../backend/noticias.php?accion=borrar&id=${id}`, {
        method: "POST"
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            cargarNoticias();
        } else {
            alert(data.error);
        }
    });
}
