<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "gestor_archivos_db";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos.");
}

$conexion->set_charset("utf8mb4");

?>