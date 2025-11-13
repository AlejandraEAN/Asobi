<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>ASOBI - Encuentros Deportivos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- FullCalendar -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
</head>

<body>
  <header class="hero-slider">
    <div class="slide active" style="background-image: url('https://www.lavanguardia.com/files/article_main_microformat/uploads/2017/05/31/5fa3ca87cd437.jpeg');"></div>
    <div class="slide" style="background-image: url('https://files.visitbogota.co/sites/default/files/2025-04/0106%20%281%29.jpg');"></div>
    <div class="slide" style="background-image: url('https://s0.wklcdn.com/image_383/11512895/113478893/72967467.400x300.jpg');"></div>
    <div class="overlay"></div>
    <div class="hero-content text-center">
      <h1 class="hero-title">ASOBI</h1>
      <p class="hero-subtitle">Conecta. Entrena. Comparte tu pasión por el deporte.</p>
      <a href="#registro" class="btn btn-outline-light btn-lg mt-3">Únete a la comunidad</a>
    </div>
  </header>

  <nav class="bg-light text-center p-3">
    <a class="mx-3" href="#inicio">Inicio</a>
    <a class="mx-3" href="#galeria">Galería</a>
    <a class="mx-3" href="#eventos">Eventos</a>
    <a class="mx-3" href="#contacto">Contacto</a>
  </nav>

  <main class="container my-5">

    <!-- Inicio -->
    <section id="inicio" class="my-5 text-center">
      <h2>¿Qué es ASOBI?</h2>
      <p class="lead">ASOBI conecta a personas apasionadas por el deporte para organizar y participar en encuentros deportivos.</p>
    </section>

    <!-- Registro -->
    <section id="registro" class="my-5">
      <h2>Registro de Usuario</h2>
      <form id="formRegistro" class="bg-light p-3 rounded">
        <input type="text" id="nombreRegistro" class="form-control mb-2" placeholder="Nombre">
        <input type="email" id="correoRegistro" class="form-control mb-2" placeholder="Correo">
        <input type="password" id="passwordRegistro" class="form-control mb-2" placeholder="Contraseña">
        <button type="button" class="btn btn-primary w-100" onclick="registrarUsuario()">Registrarse</button>
      </form>
    </section>

    <!-- Login -->
    <section id="login" class="my-5">
      <h2>Inicio de Sesión</h2>
      <form id="formLogin" class="bg-light p-3 rounded">
        <input type="email" id="correoLogin" class="form-control mb-2" placeholder="Correo">
        <input type="password" id="passwordLogin" class="form-control mb-2" placeholder="Contraseña">
        <button type="button" class="btn btn-success w-100" onclick="iniciarSesion()">Iniciar Sesión</button>
      </form>
    </section>

    <!-- Eventos -->
    <section id="eventos" class="my-5">
      <h2>Gestión de Eventos</h2>
      <form id="formEvento" class="bg-light p-3 rounded mb-4" onsubmit="return false;">
        <input type="text" id="nombreEvento" class="form-control mb-2" placeholder="Nombre del evento">
        <input type="date" id="fechaEvento" class="form-control mb-2">
        <input type="text" id="lugarEvento" class="form-control mb-2" placeholder="Lugar">
        <button type="button" class="btn btn-warning w-100" onclick="crearEvento()">Crear evento</button>
      </form>

      <div id="mapaEventos" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>
      <div id="calendarioEventos"></div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="my-5">
      <h2>Contacto</h2>
      <form class="p-3 bg-light rounded">
        <input type="text" class="form-control mb-2" placeholder="Tu nombre">
        <input type="email" class="form-control mb-2" placeholder="Tu correo">
        <textarea class="form-control mb-2" placeholder="Mensaje"></textarea>
        <button class="btn btn-primary w-100">Enviar</button>
      </form>
    </section>

  </main>

  <footer class="footer text-white text-center p-3">© ASOBI</footer>

  <script src="script.js"></script>
</body>
</html>