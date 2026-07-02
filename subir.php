<?php

include("auth.php");

define('APP_RUNNING', true);
require_once "GestorArchivos.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_FILES["archivo"])) {
        $mensaje = urlencode("Debe seleccionar un archivo.");
        header("Location: index.php?mensaje=" . $mensaje);
        exit();
    }

    $archivo = $_FILES["archivo"];

    if ($archivo["error"] == UPLOAD_ERR_NO_FILE) {
        $mensaje = urlencode("No se seleccionó ningún archivo.");
        header("Location: index.php?mensaje=" . $mensaje);
        exit();
    }

    if ($archivo["error"] != UPLOAD_ERR_OK) {
        $mensaje = urlencode("No se pudo subir el archivo.");
        header("Location: index.php?mensaje=" . $mensaje);
        exit();
    }

    $nombreOriginal = $archivo["name"];
    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

    $permitidas = ["pdf", "jpg", "png"];

    if (!in_array($extension, $permitidas)) {
        $mensaje = urlencode("Archivo no permitido. Solo se permiten archivos PDF, JPG y PNG.");
        header("Location: index.php?mensaje=" . $mensaje);
        exit();
    }

    $gestor = new GestorArchivos("uploads");
    $resultado = $gestor->subir($archivo);

    $mensaje = urlencode($resultado);
    header("Location: index.php?mensaje=" . $mensaje);
    exit();

} else {
    header("Location: index.php");
    exit();
}

?>