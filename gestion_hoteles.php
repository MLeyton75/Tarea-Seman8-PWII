<?php
include 'db.php';

// Manejo de formularios de inserción, edición y eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $nombre = $_POST['nombre'];
        $ubicacion = $_POST['ubicacion'];
        $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
        $tarifa_noche = $_POST['tarifa_noche'];

        $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES ('$nombre', '$ubicacion', $habitaciones_disponibles, $tarifa_noche)";
        if ($conn->query($sql) === TRUE) {
            echo "Nuevo hotel agregado exitosamente<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    } elseif (isset($_POST['edit'])) {
        $id_hotel = $_POST['id_hotel'];
        $nombre = $_POST['nombre'];
        $ubicacion = $_POST['ubicacion'];
        $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
        $tarifa_noche = $_POST['tarifa_noche'];

        $sql = "UPDATE HOTEL SET nombre='$nombre', ubicacion='$ubicacion', habitaciones_disponibles=$habitaciones_disponibles, tarifa_noche=$tarifa_noche WHERE id_hotel=$id_hotel";
        if ($conn->query($sql) === TRUE) {
            echo "Hotel actualizado exitosamente<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    } elseif (isset($_POST['delete'])) {
        $id_hotel = $_POST['id_hotel'];
        $sql = "DELETE FROM HOTEL WHERE id_hotel=$id_hotel";
        if ($conn->query($sql) === TRUE) {
            echo "Hotel eliminado exitosamente<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
}

// Obtener todos los hoteles
$sql = "SELECT * FROM HOTEL";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
 <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuración de la vista para dispositivos móviles -->
 <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Enlace a la fuente externa de Google Fonts -->
 <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS externo -->
    <title>Gestión de Hoteles</title>
</head>

<body>
    <h1>Gestión de Hoteles</h1>

    <h2>Agregar Hotel</h2>
    <form action="gestion_hoteles.php" method="post">
        Nombre: <input type="text" name="nombre" required>
        Ubicación: <input type="text" name="ubicacion" required>
        Habitaciones Disponibles: <input type="number" name="habitaciones_disponibles" required>
        Tarifa por Noche: <input type="text" name="tarifa_noche" required><br><br>
        <input type="submit" name="add" value="Agregar">
    </form>

    <h2>Lista de Hoteles</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Habitaciones Disponibles</th>
            <th>Tarifa por Noche</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <form action="gestion_hoteles.php" method="post">
                <input type="hidden" name="id_hotel" value="<?php echo $row['id_hotel']; ?>">
                <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                <td><input type="text" name="ubicacion" value="<?php echo $row['ubicacion']; ?>"></td>
                <td><input type="number" name="habitaciones_disponibles" value="<?php echo $row['habitaciones_disponibles']; ?>"></td>
                <td><input type="text" name="tarifa_noche" value="<?php echo $row['tarifa_noche']; ?>"></td>
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
