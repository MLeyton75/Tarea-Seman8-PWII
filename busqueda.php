<?php
include 'Filtro.php';

// Función para formatear fecha de YYYY-MM-DD a DD-MM-YYYY
function formatearFecha($fecha) {
    $partes = explode("-", $fecha);
    return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
}

$id = isset($_POST['id']) ? $_POST['id'] : '';
$tipo_servicio = isset($_POST['tipo_servicio']) ? $_POST['tipo_servicio'] : '';
$nombre_hotel = isset($_POST['nombre_hotel']) ? $_POST['nombre_hotel'] : '';
$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';
$pais = isset($_POST['pais']) ? $_POST['pais'] : '';
$fecha_viaje = isset($_POST['fecha_viaje']) ? $_POST['fecha_viaje'] : '';
$duracion_viaje = isset($_POST['duracion_viaje']) ? $_POST['duracion_viaje'] : '';

// Validar si la fecha es pasada
if ($fecha_viaje && strtotime($fecha_viaje) < strtotime(date('Y-m-d'))) {
    echo "<p class='mensaje-error'>La fecha de viaje no puede ser una fecha pasada.</p>";
    exit;
}

$resultados = Filtro::buscarDestinos($id, $tipo_servicio, $nombre_hotel, $ciudad, $pais, $fecha_viaje, $duracion_viaje);

if (empty($resultados)) {
    echo "<p class='mensaje-error'>No se encontraron resultados para la búsqueda realizada.</p>";
} else {
    echo "<div id='results-container'>";
    foreach ($resultados as $resultado) {
        $fecha_viaje_formateada = formatearFecha($resultado->fecha_viaje);

        echo "<div class='resultado' data-nombre='{$resultado->nombre_hotel}' data-precio='{$resultado->precio}'>";
        echo "<h3>{$resultado->nombre_hotel} - {$resultado->ciudad}, {$resultado->pais}</h3>";
        echo "<div class='info-servicio'>";
        echo "<p><span class='info-titulo'>Id :</span> <span class='info-dato'>{$resultado->id}</span></p>";
        echo "<p><span class='info-titulo'>Tipo de Servicio :</span> <span class='info-dato'>{$resultado->tipo_servicio}</span></p>";
        echo "<p><span class='info-titulo'>Precio USD :</span> <span class='info-dato'>\${$resultado->precio}</span></p>";
        echo "<p><span class='info-titulo'>Fecha de Viaje :</span> <span class='info-dato'>{$fecha_viaje_formateada}</span></p>";
        echo "<p><span class='info-titulo'>Duración del Viaje :</span> <span class='info-dato'>{$resultado->duracion_viaje} días</span></p>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}
?>
