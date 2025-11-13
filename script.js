// --- Registro de usuario ---
async function registrarUsuario() {
  const nombre = document.getElementById('nombreRegistro').value;
  const correo = document.getElementById('correoRegistro').value;
  const password = document.getElementById('passwordRegistro').value;

  const datos = new FormData();
  datos.append('nombre', nombre);
  datos.append('correo', correo);
  datos.append('password', password);

  const res = await fetch('registrar_usuario.php', { method: 'POST', body: datos });
  const data = await res.json();
  alert(data.message);
}

// --- Login ---
async function iniciarSesion() {
  const correo = document.getElementById('correoLogin').value;
  const password = document.getElementById('passwordLogin').value;

  const datos = new FormData();
  datos.append('correo', correo);
  datos.append('password', password);

  const res = await fetch('login_usuario.php', { method: 'POST', body: datos });
  const data = await res.json();
  alert(data.message);
}

// --- Crear evento ---
async function crearEvento() {
  const nombre = document.getElementById('nombreEvento').value;
  const fecha = document.getElementById('fechaEvento').value;
  const lugar = document.getElementById('lugarEvento').value;

  const datos = new FormData();
  datos.append('nombre', nombre);
  datos.append('fecha', fecha);
  datos.append('lugar', lugar);

  const res = await fetch('eventos.php', { method: 'POST', body: datos });
  const data = await res.json();
  alert(data.message);
  if (data.success) cargarEventos();
}

// --- Cargar mapa y calendario ---
let map, markers = [];
let calendar;

document.addEventListener('DOMContentLoaded', cargarEventos);

async function cargarEventos() {
  const res = await fetch('eventos.php');
  const data = await res.json();

  if (data.success) {
    mostrarMapaEventos(data.eventos);
    mostrarCalendarioEventos(data.eventos);
  }
}

// --- Leaflet ---
function mostrarMapaEventos(eventos) {
  if (!map) {
    map = L.map('mapaEventos').setView([4.65, -74.1], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);
  }

  markers.forEach(m => map.removeLayer(m));
  markers = [];

  eventos.forEach(e => {
    if (e.lat && e.lng) {
      const marker = L.marker([e.lat, e.lng]).addTo(map)
        .bindPopup(`<b>${e.nombre}</b><br>${e.lugar}<br>${e.fecha}`);
      markers.push(marker);
    }
  });
}

// --- FullCalendar ---
function mostrarCalendarioEventos(eventos) {
  const el = document.getElementById('calendarioEventos');
  if (!calendar) {
    calendar = new FullCalendar.Calendar(el, {
      initialView: 'dayGridMonth',
      height: 500
    });
    calendar.render();
  }
  calendar.removeAllEvents();
  eventos.forEach(e => calendar.addEvent({ title: e.nombre, start: e.fecha }));
}