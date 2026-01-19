function cargarPatrocinadores() {
    fetch("../backend/patrocinadores.php?accion=listar")
        .then(r => r.json())
        .then(datos => {
            let html = "";
            datos.forEach(p => {
                html += `
                <div style="margin-bottom:15px;">
                    <img src="${p.logo}" width="100"><br>
                    <strong>${p.nombre}</strong><br>
                    <button onclick="eliminarPatrocinador(${p.id_patrocinador})">🗑 Eliminar</button>
                </div>`;
            });
            document.getElementById("listaPatrocinadores").innerHTML = html;
        });
}

document.getElementById("formPatrocinador").addEventListener("submit", e => {
    e.preventDefault();
    let form = new FormData(e.target);

    fetch("../backend/patrocinadores.php?accion=crear", {
        method: "POST",
        body: form
    })
    .then(() => {
        e.target.reset();
        cargarPatrocinadores();
    });
});

function eliminarPatrocinador(id) {
    if (!confirm("¿Eliminar patrocinador?")) return;

    let form = new FormData();
    form.append("id", id);

    fetch("../backend/patrocinadores.php?accion=eliminar", {
        method: "POST",
        body: form
    }).then(() => cargarPatrocinadores());
}
