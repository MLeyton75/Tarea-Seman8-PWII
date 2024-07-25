<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Marce_75";
$dbname = "AGENCIA";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para verificar usuario y contraseña en la tabla 'users'
$sql = "SELECT * FROM users WHERE nombre = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Usuario autenticado correctamente como administrador
    $_SESSION['admin_loggedin'] = true;
    $_SESSION['admin_username'] = $username;
    header("Location: administracion.php"); // Redirigir a la página de administración
} else {
    // Error de autenticación
    echo "Nombre de usuario o contraseña incorrectos.";
}

$conn->close();
?>
