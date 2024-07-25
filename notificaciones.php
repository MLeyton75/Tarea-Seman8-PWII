<?php
// notificaciones.php

// Mensajes de las notificaciones
$ofertaEspecial = "¡Oferta especial! 20% de descuento en todos los productos.";
$recordatorio = "Recuerda completar tu perfil para obtener mejores recomendaciones.";
$nuevaFuncionalidad = "¡Nueva funcionalidad! Ahora puedes seguir a tus tiendas favoritas.";

// Lógica para determinar si se muestran las notificaciones
$mostrarOfertaEspecial = true;
$mostrarRecordatorio = true;
$mostrarNuevaFuncionalidad = true;

echo "<script type='text/javascript'>
        window.onload = function() {";

if ($mostrarOfertaEspecial) {
    echo "alert('$ofertaEspecial');";
}

if ($mostrarRecordatorio) {
    echo "alert('$recordatorio');";
}

if ($mostrarNuevaFuncionalidad) {
    echo "alert('$nuevaFuncionalidad');";
}

echo "}
      </script>";
?>
