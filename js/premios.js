function cargarPremios() {
  fetch("../backend/premios.php?accion=listar")
    .then(r => r.json())
    .then(data => {
      const sel = document.querySelector('[name="id_premio"]');
      sel.innerHTML = "";
      data.premios.forEach(p => {
        sel.innerHTML += `<option value="${p.id_premio}">${p.nombre}</option>`;
      });
    });
}

function cargarCandidaturas() {
  fetch("../backend/candidaturas.php?accion=listar")
    .then(r => r.json())
    .then(data => {
      const sel = document.querySelector('[name="id_inscripcion"]');
      sel.innerHTML = "";
      data.candidaturas.forEach(c => {
        sel.innerHTML += `
          <option value="${c.id_inscripcion}">
            ${c.titulo || c.nombre_responsable} (${c.estado})
          </option>`;
      });
    });
}

document.getElementById("formGanador").addEventListener("submit", e => {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch("../backend/premios.php?accion=asignar", {
    method: "POST",
    body: formData
  })
  .then(r => r.json())
  .then(data => {
    document.getElementById("resultadoGanador").innerText =
      data.ok ? "Premio asignado" : data.error;
  });
});

cargarPremios();
cargarCandidaturas();
document.getElementById("formPremio").addEventListener("submit", e => {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch("../backend/premios.php?accion=crear", {
    method: "POST",
    body: formData
  })
  .then(r => r.json())
  .then(data => {
    if (data.ok) {
      e.target.reset();
      cargarPremios();
    } else {
      alert(data.error);
    }
  });
});
