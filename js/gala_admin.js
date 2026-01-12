function cargarModo() {
    fetch("../backend/gala_estado.php?accion=get")
        .then(res => res.json())
        .then(data => {
            document.getElementById("modoActual").innerText = data.modo;

            document.getElementById("galaPre").style.display =
                data.modo === "pre" ? "block" : "none";

            document.getElementById("galaPost").style.display =
                data.modo === "post" ? "block" : "none";

            if (data.modo === "pre") cargarSecciones();
        });
}

function cambiarModo() {
    fetch("../backend/gala_estado.php?accion=toggle")
        .then(() => cargarModo());
}

/* ================= PRE EVENTO ================= */

function mostrarFormSeccion() {
    document.getElementById("formSeccion").style.display = "block";
}

function ocultarFormSeccion() {
    document.getElementById("formSeccion").reset();
    document.getElementById("formSeccion").style.display = "none";
}

function cargarSecciones() {
    fetch("../backend/gala_secciones.php?accion=listar")
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById("listaSecciones");
            cont.innerHTML = "";

            data.forEach(s => {
                cont.innerHTML += `
                    <div class="news-card">
                        <strong>${s.hora}</strong> – ${s.titulo} (${s.sala})
                        <p>${s.descripcion}</p>
                    </div>
                `;
            });
        });
}

document.getElementById("formSeccion")?.addEventListener("submit", e => {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch("../backend/gala_secciones.php?accion=crear", {
        method: "POST",
        body: formData
    }).then(() => {
        ocultarFormSeccion();
        cargarSecciones();
    });
});
/* ===============================
   TEXTO RESUMEN
================================ */
document.getElementById("formResumen")?.addEventListener("submit", e => {
    e.preventDefault();

    const datos = new FormData(e.target);

    fetch("../backend/gala_post.php?accion=guardarResumen", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(() => alert("Resumen guardado"));
});

/* ===============================
   SUBIR IMAGEN
================================ */
document.getElementById("formImagen")?.addEventListener("submit", e => {
    e.preventDefault();

    const datos = new FormData(e.target);

    fetch("../backend/gala_post.php?accion=subirImagen", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(() => alert("Imagen subida"));
});
