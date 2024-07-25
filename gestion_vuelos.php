<?php
include 'db.php';

$error_message = "";

// Manejo de formularios de inserción, edición y eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add']) || isset($_POST['edit'])) {
        $origen = $_POST['origen'];
        $destino = $_POST['destino'];
        $fecha = $_POST['fecha'];
        $plazas_disponibles = $_POST['plazas_disponibles'];
        $precio = $_POST['precio'];

        // Validar si el origen y destino son iguales
        if ($origen == $destino) {
            $error_message = "El origen y el destino no pueden ser iguales.";
        } elseif (strtotime($fecha) < strtotime(date('Y-m-d'))) {
            // Validar si la fecha es pasada
            $error_message = "La fecha de viaje no puede ser una fecha pasada.";
        } else {
            if (isset($_POST['add'])) {
                $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) VALUES ('$origen', '$destino', '$fecha', $plazas_disponibles, $precio)";
                if ($conn->query($sql) === TRUE) {
                    echo "Nuevo vuelo agregado exitosamente<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
            } elseif (isset($_POST['edit'])) {
                $id_vuelo = $_POST['id_vuelo'];
                $sql = "UPDATE VUELO SET origen='$origen', destino='$destino', fecha='$fecha', plazas_disponibles=$plazas_disponibles, precio=$precio WHERE id_vuelo=$id_vuelo";
                if ($conn->query($sql) === TRUE) {
                    echo "Vuelo actualizado exitosamente<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id_vuelo = $_POST['id_vuelo'];
        $sql = "DELETE FROM VUELO WHERE id_vuelo=$id_vuelo";
        if ($conn->query($sql) === TRUE) {
            echo "Vuelo eliminado exitosamente<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
}

// Obtener todos los vuelos
$sql = "SELECT * FROM VUELO";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Gestión de Vuelos</title>
</head>
<body>
    <h1>Gestión de Vuelos</h1>

    <h2>Agregar Vuelo</h2>
    <form action="gestion_vuelos.php" method="post">
        Origen: <input type="text" name="origen" required>
        Destino: <input type="text" name="destino" required>
        Fecha: <input type="date" name="fecha" required><br>
        Plazas Disponibles: <input type="number" name="plazas_disponibles" required>
        Precio: <input type="text" name="precio" required><br><br>
        <input type="submit" name="add" value="Agregar">
    </form>

    <h2>Lista de Vuelos</h2>
    <?php if ($error_message) { echo "<p class='mensaje-error'>$error_message</p>"; } ?>
    <table border="1">
        <tr>
            <th>Origen</th>
            <th>Destino</th>
            <th>Fecha</th>
            <th>Plazas Disponibles</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <form action="gestion_vuelos.php" method="post">
                <input type="hidden" name="id_vuelo" value="<?php echo $row['id_vuelo']; ?>">
                <td><input type="text" name="origen" value="<?php echo $row['origen']; ?>"></td>
                <td><input type="text" name="destino" value="<?php echo $row['destino']; ?>"></td>
                <td><input type="date" name="fecha" value="<?php echo $row['fecha']; ?>"></td>
                <td><input type="number" name="plazas_disponibles" value="<?php echo $row['plazas_disponibles']; ?>"></td>
                <td><input type="text" name="precio" value="<?php echo $row['precio']; ?>"></td>
                <td>
                    <input type="submit" name="edit" value="Actualizar">
                    <input type="submit" name="delete" value="Eliminar">
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
    <br>
    <a href="administracion.php" class="button-link">Volver</a>
</body>
</html>

<?php $conn->close(); ?>
