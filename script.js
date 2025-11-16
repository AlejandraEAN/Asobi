/* ============================================================
   USUARIOS
============================================================ */

// Registro de usuario
function registrarUsuario() {
    const nombre = document.getElementById('nombreRegistro').value.trim();
    const correo = document.getElementById('correoRegistro').value.trim();
    const password = document.getElementById('passwordRegistro').value;

    if (!nombre || !correo || !password) {
        alert("Completa todos los campos");
        return;
    }

    const formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("correo", correo);
    formData.append("password", password);

    fetch("registrar_usuario.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            document.getElementById("formRegistro").reset();
        }
    })
    .catch(err => console.error("Error:", err));
}

// Login de usuario
function iniciarSesion() {
    const correo = document.getElementById('correoLogin').value.trim();
    const password = document.getElementById('passwordLogin').value;

    if (!correo || !password) {
        alert("Completa todos los campos");
        return;
    }

    const formData = new FormData();
    formData.append('correo', correo);
    formData.append('password', password);

    fetch('login_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Bienvenido " + data.nombre);
            localStorage.setItem("usuario_asobi", data.correo);
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error("Error:", err));
}



/* ============================================================
   CANCHAS DESDE MYSQL + GOOGLE MAPS
============================================================ */

let canchas = [];
let mapa;

// Cargar canchas desde BD
function cargarCanchasBD() {
    fetch("obtener_canchas.php")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                canchas = data.data;
                iniciarMapa();
                cargarListaCanchas();
            } else {
                console.error("No se pudieron cargar canchas");
            }
        })
        .catch(err => console.error("Error cargando canchas:", err));
}

// Inicializar Google Maps
function iniciarMapa() {
    const mapEl = document.getElementById("mapaCanchas");
    if (!mapEl) return;

    mapa = new google.maps.Map(mapEl, {
        center: { lat: 4.65, lng: -74.09 },
        zoom: 12
    });

    mostrarCanchas();
}

function mostrarCanchas() {
    if (!mapa || !canchas) return;
    
    canchas.forEach(c => {
        new google.maps.Marker({
            position: { lat: parseFloat(c.lat), lng: parseFloat(c.lng) },
            map: mapa,
            title: c.nombre,
            icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
        });
    });
}

// Lista de canchas
function cargarListaCanchas() {
    const lista = document.getElementById("listaCanchas");
    if (!lista) return;

    lista.innerHTML = "";

    canchas.forEach(c => {
        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";

        li.innerHTML = `
            ${c.nombre}
            <button class="btn btn-primary btn-sm" onclick="reservarCancha(${c.id}, '${c.nombre}')">Reservar</button>
        `;

        lista.appendChild(li);
    });
}



/* ============================================================
   RESERVAS (MYSQL)
============================================================ */

function cargarReservasBD() {
    fetch("obtener_reservas.php")
        .then(res => res.json())
        .then(data => {
            const lista = document.getElementById("listaPartidos");
            if (!lista) return;

            lista.innerHTML = "";

            if (!data.success || data.data.length === 0) {
                lista.innerHTML = `
                    <li class="list-group-item text-muted">
                        No hay partidos programados.
                    </li>`;
                return;
            }

            data.data.forEach(r => {
                
                // Convertimos fecha y hora al formato ISO para Calendar
                const fechaISO = `${r.fecha}T${r.hora}:00`;

                const googleURL = 
                  `https://calendar.google.com/calendar/render?action=TEMPLATE` +
                  `&text=Partido%20en%20${encodeURIComponent(r.cancha)}` +
                  `&dates=${fechaISO}/${fechaISO}` +
                  `&details=Reserva%20de%20cancha%20-%20ASOBI` +
                  `&location=${encodeURIComponent(r.cancha)}`;

                const outlookURL =
                  `https://outlook.live.com/calendar/0/deeplink/compose?subject=` +
                  `Partido%20en%20${encodeURIComponent(r.cancha)}` +
                  `&startdt=${fechaISO}&enddt=${fechaISO}` +
                  `&body=Reserva%20ASOBI` +
                  `&location=${encodeURIComponent(r.cancha)}`;

                const li = document.createElement("li");
                li.classList = "list-group-item";

                li.innerHTML = `
                    <strong>${r.cancha}</strong><br>
                    📅 ${r.fecha} &nbsp;&nbsp; ⏰ ${r.hora}<br>
                    👤 ${r.usuario}<br><br>

                    <a class="btn btn-success btn-sm me-2" href="${googleURL}" target="_blank">
                        Añadir a Google Calendar
                    </a>

                    <a class="btn btn-primary btn-sm" href="${outlookURL}" target="_blank">
                        Añadir a Outlook
                    </a>
                `;

                lista.appendChild(li);
            });
        })
        .catch(err => {
            console.error("Error cargando reservas:", err);
            alert("Error obteniendo reservas. Revisa la consola.");
        });
}



function reservarCancha(cancha_id, cancha_nombre) {
    const fecha = prompt("Fecha (AAAA-MM-DD):");
    const hora = prompt("Hora (HH:MM):");
    const usuario = localStorage.getItem("usuario_asobi") || prompt("Correo del usuario:");

    if (!fecha || !hora || !usuario) return;

    const formData = new FormData();
    formData.append("cancha_id", cancha_id);
    formData.append("fecha", fecha);
    formData.append("hora", hora);
    formData.append("usuario", usuario);

    fetch("crear_reserva.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        cargarReservasBD();
    })
    .catch(err => console.error("Error al reservar:", err));
}



/* ============================================================
   FULLCALENDAR (EVENTOS BD)
============================================================ */

let calendar;

function cargarCalendario() {
    console.log("⏳ Iniciando FullCalendar...");

    if (typeof FullCalendar === "undefined") {
        console.error("❌ FullCalendar NO está cargado");
        return;
    }

    const calendarEl = document.getElementById("calendarioEventos");
    if (!calendarEl) {
        console.error("❌ Div #calendarioEventos no existe");
        return;
    }

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        height: 600,
        locale: "es",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay"
        },
        events: function(fetchInfo, success, fail) {
            fetch("obtener_eventos.php")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        success(data.data.map(ev => ({
                            title: ev.nombre,
                            start: ev.fecha,
                            extendedProps: { lugar: ev.lugar }
                        })));
                    } else {
                        success([]);
                    }
                })
                .catch(err => fail(err));
        },
        eventClick: function(info) {
            alert(
                `📍 ${info.event.title}\n📆 ${info.event.start.toLocaleString()}\n📌 ${info.event.extendedProps.lugar}`
            );
        }
    });

    calendar.render();
}



/* ============================================================
   CREAR EVENTO (MYSQL)
============================================================ */

function crearEvento() {
    const nombre = document.getElementById("nombreEvento").value.trim();
    const fecha = document.getElementById("fechaEvento").value;
    const lugar = document.getElementById("lugarEvento").value.trim();

    if (!nombre || !fecha || !lugar) {
        alert("Por favor completa todos los campos del evento.");
        return;
    }

    const formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("fecha", fecha);
    formData.append("lugar", lugar);

    fetch("crear_evento.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);

        if (data.success) {
            document.getElementById("formEvento").reset();

            // Refresca eventos en el calendario si existe
            if (typeof calendar !== "undefined" && calendar) {
                calendar.refetchEvents();
            }

            // Refresca lista de eventos si existe
            if (typeof cargarEventosBD === "function") {
                cargarEventosBD();
            }
        }
    })
    .catch(err => console.error("Error creando evento:", err));
}




/* ============================================================
   INICIO AUTOMÁTICO
============================================================ */

document.addEventListener("DOMContentLoaded", () => {
    cargarCanchasBD();
    cargarReservasBD();
    setTimeout(() => cargarCalendario(), 500);
});
