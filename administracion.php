<?php
session_start();

// Verificar si el usuario administrativo ha iniciado sesión
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header("Location: login_admin.php");
    exit;
}

// Proceso para cerrar sesión
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Administración</title>

</head>

<body>
    <h1>Panel de Administración</h1>
    <h2>Opciones de Gestión</h2>
    <ul>
        <li><a href="gestion_vuelos.php">Gestión de Vuelos</a></li>
        <li><a href="gestion_hoteles.php">Gestión de Hoteles</a></li>
        <li><a href="gestion_reservas.php">Gestión de Reservas</a></li>
        <li><a href="consultas.php">Reportes(consultas)</a></li>
    </ul>
    <br><br><br>
    <!-- Enlaces para cerrar sesión y volver al index -->
    <div class="logout-section">
        <a href="?logout" class="logout-link">Cerrar sesión</a>

    </div>

    <footer>
        <p>&copy; 2024 Agencia de Viajes</p>
    </footer>
</body>

</html>