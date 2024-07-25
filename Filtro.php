<?php
include 'ConexionBD.php';// conexion bd
// Definición de la clase Filtro
class Filtro {
     // Propiedades de la clase
    public $id;
    public $tipo_servicio;
    public $nombre_hotel;
    public $ciudad;
    public $pais;
    public $fecha_viaje;
    public $duracion_viaje;
    public $precio;

     // Constructor de la clase
    public function __construct($id, $tipo_servicio, $nombre_hotel, $ciudad, $pais, $fecha_viaje, $duracion_viaje, $precio) {
          // Inicialización de las propiedades de la clase
        $this->id = $id; 
        $this->tipo_servicio = $tipo_servicio;
        $this->nombre_hotel = $nombre_hotel;
        $this->ciudad = $ciudad;
        $this->pais = $pais;
        $this->fecha_viaje = $fecha_viaje;
        $this->duracion_viaje = $duracion_viaje;
        $this->precio = $precio;
    }
 // Método para validar la fecha de viaje
    public function validarFecha() {
          // Obtiene la fecha actual
        $fecha_actual = date('Y-m-d');
           // Verifica si la fecha de viaje es en el pasado
        if ($this->fecha_viaje < $fecha_actual) {
             // Retorna un mensaje de error si la fecha es en el pasado
            return "<span class='mensaje-error'>La fecha de viaje no puede ser en el pasado.</span>";
        }
             // Retorna verdadero si la fecha es válida
        return true;
    }
// Método estático para buscar destinos basados en los filtros proporcionados
    public static function buscarDestinos($id, $tipo_servicio, $nombre_hotel, $ciudad, $pais, $fecha_viaje, $duracion_viaje) {
        global $conexionBD;

        $query = "SELECT * FROM simulaciones WHERE 1=1";

          // Condiciones a la consulta basado en los filtros proporcionados

          if ($id) {
            $query .= " AND id = '$id'";
        }

        if ($tipo_servicio) {
            $query .= " AND tipo_servicio = '$tipo_servicio'";
        }
        if ($nombre_hotel) {
            $query .= " AND nombre_hotel = '$nombre_hotel'";
        }
        if ($ciudad) {
            $query .= " AND ciudad = '$ciudad'";
        }
        if ($pais) {
            $query .= " AND pais = '$pais'";
        }
        if ($fecha_viaje) {
            $query .= " AND fecha_viaje = '$fecha_viaje'";
        }
        if ($duracion_viaje) {
            $query .= " AND duracion_viaje = $duracion_viaje";
        }

         // Ejecucion de la consulta
        $result = $conexionBD->query($query);

         // Array para almacenar los resultados
        $resultados = [];
        while ($row = $result->fetch_assoc()) {

                // Cada resultado al array como una nueva instancia de Filtro
            $resultados[] = new Filtro(
                $row['id'],
                $row['tipo_servicio'],
                $row['nombre_hotel'],
                $row['ciudad'],
                $row['pais'],
                $row['fecha_viaje'],
                $row['duracion_viaje'],
                $row['precio']
            );
        }

        return $resultados;
    }
}
?>
