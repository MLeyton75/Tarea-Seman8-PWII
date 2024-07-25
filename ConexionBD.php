<?php

$server = 'localhost';
$user = 'root';
$pass = 'Marce_75';
$db = 'agenciabd';

$conexionBD = new mysqli($server, $user, $pass, $db);

if ($conexionBD->connect_errno) {
    die("Conexión Fallida" . $conexionBD->connect_errno);
} 
?>