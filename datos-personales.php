<?php
// Establecer el tiempo máximo de vida de una sesión en segundos (45 segundos)
ini_set('session.gc_maxlifetime', 45);

session_start();

// Regenerar la ID de la sesión para evitar ataques de fijación de sesión
session_regenerate_id(true);

// Destruir la sesión si se ha enviado el parámetro `logout`
if (isset($_GET['logout'])) {
    session_destroy();
    // Redirige al usuario a la página principal o de inicio de sesión después de destruir la sesión
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS externo -->
    <title>Datos Personales</title>
    <style>
        .session-timer {
            font-size: 1.2em;
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <h1>Datos Personales</h1>
    <div class="session-timer" id="session-timer">Tiempo restante de sesión: 45 segundos</div>
    <form action="detalles-tarjeta.php" method="POST" onsubmit="guardarDatosPersonales()">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="email">Correo:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <button type="submit" class="btn">Continuar</button>
    </form>

    <script>
        let sessionTime = 45; // Tiempo de sesión en segundos

        function updateSessionTimer() {
            const timerElement = document.getElementById('session-timer');
            sessionTime--;
            timerElement.textContent = `Tiempo restante de sesión: ${sessionTime} segundos`;
            if (sessionTime <= 0) {
                clearInterval(sessionInterval);
                alert('La sesión ha expirado. Será redirigido a la página principal.');
                window.location.href = 'index.php';
            }
        }

        const sessionInterval = setInterval(updateSessionTimer, 1000);

        function guardarDatosPersonales() {
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            const telefono = document.getElementById('telefono').value;
            const email = document.getElementById('email').value;

            localStorage.setItem('nombre', nombre);
            localStorage.setItem('apellido', apellido);
            localStorage.setItem('telefono', telefono);
            localStorage.setItem('email', email);
        }
    </script>

    <footer>
        <p>&copy; 2024 Agencia de Viajes</p> <!-- Pie de página -->
    </footer>
    <br><br><br>

    <!-- Añadir un enlace para cerrar sesión/ antes de presionar el botón pagar puede cerrar la sesión -->
    <a href="detalles-tarjeta.php?logout=true">Volver a la página principal</a>

</body>

</html>