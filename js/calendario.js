// ===============================
// MES Y AÑO ACTUAL
// ===============================
let mesActual = new Date().getMonth(); // 0 - 11
let anyoActual = new Date().getFullYear();

// ===============================
// BOTONES DE NAVEGACIÓN
// ===============================
document.getElementById("prev").onclick = () => cambiarMes(-1);
document.getElementById("next").onclick = () => cambiarMes(1);

// ===============================
// CAMBIAR MES
// ===============================
function cambiarMes(suma) {
    mesActual += suma;

    if (mesActual < 0) {
        mesActual = 11;
        anyoActual--;
    }
    if (mesActual > 11) {
        mesActual = 0;
        anyoActual++;
    }

    cargarCalendario();
}

// ===============================
// CARGAR CALENDARIO (FETCH)
// ===============================
async function cargarCalendario() {
    try {
        const res = await fetch(
            `../backend/calendario_eventos.php?mes=${mesActual + 1}&anyo=${anyoActual}`
        );
        const ocupados = await res.json();
        crearCalendario(ocupados);
    } catch (e) {
        console.error("Error cargando calendario", e);
    }
}

// ===============================
// CREAR CALENDARIO
// ===============================
function crearCalendario(ocupados) {

    const cal = document.getElementById("cal");
    cal.innerHTML = "";

    const titulo = document.getElementById("tituloMes");
    const meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    titulo.textContent = `${meses[mesActual]} ${anyoActual}`;

    // ===============================
    // CABECERA DÍAS SEMANA
    // ===============================
    const diasSemana = ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"];
    diasSemana.forEach(d => {
        cal.innerHTML += `<div class="header">${d}</div>`;
    });

    // ===============================
    // PRIMER Y ÚLTIMO DÍA DEL MES
    // ===============================
    const inicio = new Date(anyoActual, mesActual, 1);
    const fin = new Date(anyoActual, mesActual + 1, 0);

    let diaSemana = inicio.getDay(); // 0 (Dom) - 6 (Sáb)
    if (diaSemana === 0) diaSemana = 7; // domingo al final

    // ===============================
    // HUECOS ANTES DEL DÍA 1
    // ===============================
    for (let i = 1; i < diaSemana; i++) {
        cal.innerHTML += "<div></div>";
    }

    // ===============================
    // DÍAS DEL MES
    // ===============================
    for (let d = 1; d <= fin.getDate(); d++) {

        const fecha = `${anyoActual}-${String(mesActual + 1).padStart(2, "0")}-${String(d).padStart(2, "0")}`;
        const ocupado = ocupados.includes(fecha);

        cal.innerHTML += `
            <div class="dia ${ocupado ? "ocupado" : ""}">
                ${d}
            </div>
        `;
    }
}

// ===============================
// INICIALIZAR
// ===============================
cargarCalendario();
