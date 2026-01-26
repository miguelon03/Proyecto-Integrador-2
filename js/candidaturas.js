function cargarCandidaturas() {
    fetch("../backend/candidaturas_listar.php")
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById("listaCandidaturas");
            cont.innerHTML = "";

            if (!data.ok || data.candidaturas.length === 0) {
                cont.innerHTML = "<p>No hay candidaturas</p>";
                return;
            }

            data.candidaturas.forEach(c => {
                const div = document.createElement("div");
                div.className = "news-card";

                div.innerHTML = `
                    <p><strong>Usuario:</strong> ${c.nombre_responsable}</p>
                    <p><strong>Email:</strong> ${c.email}</p>
                    <p><strong>Vídeo:</strong> 
                        <a href="${c.video}" target="_blank">Ver vídeo</a>
                    </p>
                    <p><strong>Estado actual:</strong> ${c.estado}</p>

                    <select onchange="mostrarMotivo(this, ${c.id_inscripcion})">
                        <option value="">Cambiar estado</option>
                        <option value="ACEPTADO">Aceptar</option>
                        <option value="RECHAZADO">Rechazar</option>
                        <option value="NOMINADO">Nominar</option>
                    </select>

                    <div id="motivo-${c.id_inscripcion}" style="display:none;">
                        <textarea placeholder="Motivo del rechazo"></textarea>
                        <button onclick="cambiarEstado(${c.id_inscripcion}, 'RECHAZADO')">
                            Confirmar rechazo
                        </button>
                    </div>

                    <button onclick="cambiarEstado(${c.id_inscripcion}, 'ACEPTADO')">
                        Aceptar
                    </button>

                    <button onclick="cambiarEstado(${c.id_inscripcion}, 'NOMINADO')">
                        Nominar
                    </button>
                `;

                cont.appendChild(div);
            });
        });
}

function mostrarMotivo(select, id) {
    document.getElementById(`motivo-${id}`).style.display =
        select.value === "RECHAZADO" ? "block" : "none";
}

function cambiarEstado(id, estado) {
    const cont = document.getElementById(`motivo-${id}`);
    const motivo = cont ? cont.querySelector("textarea")?.value : "";

    fetch("../backend/cambiar_estado.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `id_inscripcion=${id}&estado=${estado}&motivo=${encodeURIComponent(motivo)}`
    })
    .then(() => cargarCandidaturas());
}
