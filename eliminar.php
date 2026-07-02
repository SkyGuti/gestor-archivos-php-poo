<?php

include("auth.php");

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    $mensaje = urlencode("No tienes permisos para eliminar archivos.");
    header("Location: index.php?mensaje=" . $mensaje);
    exit();
}

define('APP_RUNNING', true);
require_once "GestorArchivos.php";

if (isset($_GET["archivo"])) {

    $nombreArchivo = $_GET["archivo"];

    $gestor = new GestorArchivos("uploads");
    $resultado = $gestor->eliminar($nombreArchivo);

    $mensaje = urlencode($resultado);
    header("Location: index.php?mensaje=" . $mensaje);
    exit();

} else {
    $mensaje = urlencode("No se recibió el archivo a eliminar.");
    header("Location: index.php?mensaje=" . $mensaje);
    exit();
}

?>