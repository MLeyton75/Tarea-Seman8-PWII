<?php
include 'db.php';

$error_message = "";

// Manejo de formularios de inserción, edición y eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add']) || isset($_POST['edit'])) {
        $id_cliente = $_POST['id_cliente'];
        $fecha_reserva = $_POST['fecha_reserva'];
        $id_vuelo = $_POST['id_vuelo'];
        $id_hotel = $_POST['id_hotel'];

        // Validar si la fecha es pasada
        if (strtotime($fecha_reserva) < strtotime(date('Y-m-d'))) {
            $error_message = "La fecha de reserva no puede ser una fecha pasada.";
        } else {
            if (isset($_POST['add'])) {
                $sql = "INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES ($id_cliente, '$fecha_reserva', $id_vuelo, $id_hotel)";
                if ($conn->query($sql) === TRUE) {
                    echo "Nueva reserva agregada exitosamente<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
            } elseif (isset($_POST['edit'])) {
                $id_reserva = $_POST['id_reserva'];
                $sql = "UPDATE RESERVA SET id_cliente=$id_cliente, fecha_reserva='$fecha_reserva', id_vuelo=$id_vuelo, id_hotel=$id_hotel WHERE id_reserva=$id_reserva";
                if ($conn->query($sql) === TRUE) {
                    echo "Reserva actualizada exitosamente<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id_reserva = $_POST['id_reserva'];
        $sql = "DELETE FROM RESERVA WHERE id_reserva=$id_reserva";
        if ($conn->query($sql) === TRUE) {
            echo "Reserva eliminada exitosamente<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
}

// Obtener todas las reservas
$sql = "SELECT * FROM RESERVA";
$result = $conn->query($sql);

// Obtener todos los vuelos y hoteles para los menús desplegables
$sql_vuelos = "SELECT * FROM VUELO";
$result_vuelos = $conn->query($sql_vuelos);

$sql_hoteles = "SELECT * FROM HOTEL";
$result_hoteles = $conn->query($sql_hoteles);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuración de la vista para dispositivos móviles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Enlace a la fuente externa de Google Fonts -->
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS externo -->
    <title>Gestión de Reservas</title>
</head>
<body>
    <h1>Gestión de Reservas</h1>

    <style>
        
    </style>

    <h2>Agregar Reserva</h2>
    <form action="gestion_reservas.php" method="post">
        ID Cliente: <input type="number" name="id_cliente" required>
        Fecha Reserva: <input type="date" name="fecha_reserva" required>
        Vuelo: 
        <select name="id_vuelo" required>
            <?php while($row_vuelo = $result_vuelos->fetch_assoc()) { ?>
                <option value="<?php echo $row_vuelo['id_vuelo']; ?>"><?php echo $row_vuelo['origen'] . " - " . $row_vuelo['destino']; ?></option>
            <?php } ?>
        </select>
        Hotel: 
        <select name="id_hotel" required>
            <?php while($row_hotel = $result_hoteles->fetch_assoc()) { ?>
                <option value="<?php echo $row_hotel['id_hotel']; ?>"><?php echo $row_hotel['nombre'] . " - " . $row_hotel['ubicacion']; ?></option>
            <?php } ?>
        </select><br><br>
        <input type="submit" name="add" value="Agregar">
    </form>

    <h2>Lista de Reservas</h2>
    <?php if ($error_message) { echo "<p class='mensaje-error'>$error_message</p>"; } ?>
    <table border="1">
        <tr>
            <th>ID Cliente</th>
            <th>Fecha Reserva</th>
            <th>Vuelo</th>
            <th>Hotel</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <form action="gestion_reservas.php" method="post">
                <input type="hidden" name="id_reserva" value="<?php echo $row['id_reserva']; ?>">
                <td><input type="number" name="id_cliente" value="<?php echo $row['id_cliente']; ?>"></td>
                <td><input type="date" name="fecha_reserva" value="<?php echo $row['fecha_reserva']; ?>"></td>
                <td>
                    <select name="id_vuelo">
                        <?php
                        $result_vuelos->data_seek(0); // Reset the result set pointer
                        while($row_vuelo = $result_vuelos->fetch_assoc()) {
                            $selected = ($row_vuelo['id_vuelo'] == $row['id_vuelo']) ? 'selected' : '';
                            echo "<option value='" . $row_vuelo['id_vuelo'] . "' $selected>" . $row_vuelo['origen'] . " - " . $row_vuelo['destino'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="id_hotel">
                        <?php
                        $result_hoteles->data_seek(0); // Reset the result set pointer
                        while($row_hotel = $result_hoteles->fetch_assoc()) {
                            $selected = ($row_hotel['id_hotel'] == $row['id_hotel']) ? 'selected' : '';
                            echo "<option value='" . $row_hotel['id_hotel'] . "' $selected>" . $row_hotel['nombre'] . " - " . $row_hotel['ubicacion'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
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

<?php
$conn->close();
?>
