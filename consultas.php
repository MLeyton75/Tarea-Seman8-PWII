<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuración de la vista para dispositivos móviles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Enlace a la fuente externa de Google Fonts -->
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS externo -->
    <title>Reportes (Consultas)</title>
</head>
<body>
<?php
include 'db.php';

// Consulta para obtener el número de reservas por hotel
$query1 = "SELECT ho.nombre, COUNT(re.id_reserva) as num_reservas 
           FROM hotel ho
           LEFT JOIN reserva re ON ho.id_hotel = re.id_hotel 
           GROUP BY ho.id_hotel";
$result1 = $conn->query($query1);

echo "<h2>Número de reservas por hotel</h2>";
echo "<table border='1'>";
echo "<tr><th>Hotel</th><th>Número de Reservas</th></tr>";

while ($row = $result1->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['num_reservas']}</td>";
    echo "</tr>";
}
echo "</table>";

// Función para formatear fecha de YYYY-MM-DD a DD-MM-YYYY
function formatearFecha($fecha_reserva) {
    $partes = explode("-", $fecha_reserva);
    return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
}

$sql = "SELECT * FROM RESERVA";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Lista de Reservas</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID Reserva</th><th>ID Cliente</th><th>Fecha Reserva</th><th>ID Vuelo</th><th>ID Hotel</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_reserva"] . "</td>";
        echo "<td>" . $row["id_cliente"] . "</td>";
        echo "<td>" . formatearFecha($row["fecha_reserva"]) . "</td>";
        echo "<td>" . $row["id_vuelo"] . "</td>";
        echo "<td>" . $row["id_hotel"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron reservas.";
}

// Consulta para obtener los hoteles con más de 2 reservas
$query = "SELECT h.nombre, COUNT(r.id_reserva) as num_reservas 
          FROM hotel h 
          LEFT JOIN reserva r ON h.id_hotel = r.id_hotel 
          GROUP BY h.id_hotel 
          HAVING num_reservas > 2";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Hoteles con más de 2 reservas</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Hotel</th><th>Número de Reservas</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["num_reservas"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron hoteles con más de 2 reservas.";
}

$conn->close();
?>

<footer>
    <p>&copy; 2024 Agencia de Viajes</p>
</footer>
<br>
<a href="administracion.php" class="button-link">Volver</a>
</body>
</html>
