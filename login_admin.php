<?php

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
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="styles.css">
<title>Login Administrativo</title>
</head>
<body>
<style>


/* Estilo general para los botones */
button, input[type="submit"] {
    background-color: #4CAF50; /* Color de fondo */
    color: white; /* Color del texto */
    padding: 5px; /* Espaciado interno */
    width: 120px;
    border: none; /* Sin borde */
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
    font-family: 'Roboto', sans-serif; /* Fuente */
    font-size: 16px; /* Tamaño de fuente */
    transition: background-color 0.3s; /* Transición suave para el color de fondo */

    label[for="password"] {
        font-family: Arial, sans-serif;
        font-size: 14px;
        border-radius: 5px; /* Bordes redondeados */
        color: #333; /* Color del texto */
        display: block; /* Hace que la etiqueta ocupe toda la línea */
        margin-bottom: 8px; /* Espacio debajo de la etiqueta */
    }
}
</style>


    <h1>Inicio de Sesión Administrativo</h1>
    <form action="login_admin_process.php" method="post">
        <label for="username">Nombre de Usuario:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <br><br><br><br><br>
    <a href="index.php">Volver a la página principal</a>
    <footer>
        <p>&copy; 2024 Agencia de Viajes</p>
    </footer>
</body>
</html>