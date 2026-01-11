let categoriaEditando = null;

function mostrarFormCategoria() {
    document.getElementById("formCategoria").style.display = "block";
}

function ocultarFormCategoria() {
    document.getElementById("formCategoria").reset();
    document.getElementById("formCategoria").style.display = "none";
    document.getElementById("errorCategoria").innerText = "";
    categoriaEditando = null;
}

function cargarCategorias() {
    fetch("../backend/premios.php?accion=listarCategorias")
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById("listaCategorias");
            cont.innerHTML = "";

            data.categorias.forEach(c => {
                const div = document.createElement("div");
                div.className = "news-card";
                div.innerHTML = `
                    <h3>${c.nombre}</h3>
                    <p>${c.descripcion ?? ""}</p>
                    <button onclick="editarCategoria(${c.id_categoria}, '${c.nombre}')">Editar</button>
                    <button onclick="borrarCategoria(${c.id_categoria})">Borrar</button>
                `;
                cont.appendChild(div);
            });
        });
}

function editarCategoria(id, nombre) {
    categoriaEditando = id;
    mostrarFormCategoria();
    document.querySelector("#formCategoria input[name='nombre']").value = nombre;
}

function borrarCategoria(id) {
    if (!confirm("¿Eliminar categoría?")) return;

    fetch(`../backend/premios.php?accion=borrarCategoria&id=${id}`, { method: "POST" })
        .then(() => cargarCategorias());
}

document.getElementById("formCategoria").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    if (categoriaEditando) formData.append("id", categoriaEditando);

    const accion = categoriaEditando ? "editarCategoria" : "crearCategoria";

    fetch(`../backend/premios.php?accion=${accion}`, {
        method: "POST",
        body: formData
    })
    .then(() => {
        ocultarFormCategoria();
        cargarCategorias();
    });
});
