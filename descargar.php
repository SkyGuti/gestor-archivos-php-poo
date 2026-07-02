<?php

include("auth.php");

define('APP_RUNNING', true);
require_once "GestorArchivos.php";

// Validamos que llegue el nombre del archivo
if (!isset($_GET["archivo"])) {
    header("Location: index.php?mensaje=" . urlencode("No se recibió el archivo a descargar."));
    exit();
}

$nombreArchivo = $_GET["archivo"];

$gestor = new GestorArchivos("uploads");
$rutaArchivo = $gestor->obtenerRutaSegura($nombreArchivo);

if ($rutaArchivo == false) {
    header("Location: index.php?mensaje=" . urlencode("Archivo no válido o no encontrado."));
    exit();
}

$extension = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));

$tipos = [
    "pdf" => "application/pdf",
    "jpg" => "image/jpeg",
    "png" => "image/png"
];

if (!isset($tipos[$extension])) {
    header("Location: index.php?mensaje=" . urlencode("Tipo de archivo no permitido."));
    exit();
}

header("Content-Type: " . $tipos[$extension]);
header("Content-Disposition: attachment; filename=\"" . basename($rutaArchivo) . "\"");
header("Content-Length: " . filesize($rutaArchivo));
header("Pragma: public");
header("Cache-Control: must-revalidate");

readfile($rutaArchivo);
exit();

?>