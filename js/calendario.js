document.addEventListener('DOMContentLoaded', () => {

  const calendarEl = document.getElementById('calendar');

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    dayMaxEvents: true,

    events: '../backend/calendario_eventos.php',

    eventDidMount: function(info) {
      // 🔴 Marca en rojo los días con eventos
      const cell = info.el.closest('.fc-daygrid-day');
      if (cell) {
        cell.style.backgroundColor = '#ffe5e5';
      }
    },

    eventClick: info => {
      alert(
        info.event.title + "\n\n" +
        info.event.extendedProps.descripcion
      );
    },

    dateClick: info => {
      const fecha = info.dateStr;

      const eventosDia = calendar.getEvents().filter(ev => {
        const inicio = ev.startStr.substring(0, 10);
        const fin = ev.endStr
          ? ev.endStr.substring(0, 10)
          : inicio;

        return fecha >= inicio && fecha <= fin;
      });

      if (eventosDia.length === 0) {
        alert("No hay eventos este día");
        return;
      }

      let texto = `Eventos del ${fecha}:\n\n`;
      eventosDia.forEach(e => {
        texto += `• ${e.title}\n${e.extendedProps.descripcion}\n\n`;
      });

      alert(texto);
    }
  });

  calendar.render();
});
