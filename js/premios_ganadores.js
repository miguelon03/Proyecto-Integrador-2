function cargarGanadores() {
    fetch("../backend/ganadores.php?accion=listar")
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById("listaGanadores");
            cont.innerHTML = "";

            if (!data.ok || data.categorias.length === 0) {
                cont.innerHTML = "<p>No hay categorías</p>";
                return;
            }

            data.categorias.forEach(cat => {
                const div = document.createElement("div");
                div.className = "news-card";

                if (cat.tipo === "Carrera Profesional") {
                    // FORM MANUAL
                    div.innerHTML = `
                        <h3>${cat.nombre}</h3>
                        <form onsubmit="guardarGanador(event, ${cat.id_categoria})">
                            <input name="nombre" placeholder="Nombre completo" required>
                            <input name="email" type="email" placeholder="Email" required>
                            <input name="telefono" placeholder="Teléfono" required>
                            <input name="video" type="url" placeholder="Vídeo">
                            <button>Guardar ganador</button>
                        </form>
                    `;
                } else {
                    // SELECT DESDE BD
                    div.innerHTML = `
                        <h3>${cat.nombre}</h3>
                        <form onsubmit="guardarGanador(event, ${cat.id_categoria})">
                            <select name="ganador" required>
                                ${cat.participantes.map(p =>
                                    `<option value="${p.usuario}">${p.usuario}</option>`
                                ).join("")}
                            </select>
                            <button>Asignar ganador</button>
                        </form>
                    `;
                }

                cont.appendChild(div);
            });
        });
}

function guardarGanador(e, idCategoria) {
    e.preventDefault();
    const form = e.target;
    const datos = new FormData(form);
    datos.append("id_categoria", idCategoria);

    fetch("../backend/ganadores.php?accion=guardar", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) alert("Ganador asignado");
        else alert(data.error);
    });
}
