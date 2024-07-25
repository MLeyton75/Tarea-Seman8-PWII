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
<title>Detalles de la Tarjeta</title>
</head>
<body>

<h1>Detalles de la Tarjeta</h1>
<div class="session-timer" id="session-timer">Tiempo restante de sesión: 45 segundos</div>
<form id="tarjeta-form">
    <div class="form-group">
        <label for="tipo-tarjeta">Tipo de Tarjeta:</label>
        <select id="tipo-tarjeta" name="tipo-tarjeta" required>
            <option value="debito">Débito</option>
            <option value="credito">Crédito</option>
        </select>
    </div>
    <div class="form-group">
        <label for="numero-tarjeta">Número de Tarjeta:</label>
        <input type="text" id="numero-tarjeta" name="numero-tarjeta" required>
    </div>
    <button type="submit" class="btn">Pagar</button>
</form>

<script>
    // Script para el contador de la sesión
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

    document.getElementById('tarjeta-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario

        const tipoTarjeta = document.getElementById('tipo-tarjeta').value;
        const numeroTarjeta = document.getElementById('numero-tarjeta').value;

        localStorage.setItem('tipoTarjeta', tipoTarjeta);
        localStorage.setItem('numeroTarjeta', numeroTarjeta);

        // Notificación de envío de documento
        alert('Se envió documento a su correo electrónico: ' + localStorage.getItem('email'));

        // Resetear el carrito
        localStorage.removeItem('carrito');
        localStorage.removeItem('total');

        // Redirigir a la página principal después de pagar
        window.location.href = 'index.php';
    });
</script>


<!-- Añadir un enlace para cerrar sesión/ antes de presionar el boton pagar puede cerrar la sesion -->
 <br><br>
 
<a href="detalles-tarjeta.php?logout=true">Cerrar sesión</a>

<footer>
    <p>&copy; 2024 Agencia de Viajes</p> <!-- Pie de página -->

</body>
</html>
