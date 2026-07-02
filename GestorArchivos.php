<?php

if (!defined('APP_RUNNING')) {
    exit('Acceso directo no permitido');
}

class GestorArchivos {

    private $directorio;
    private $tamanoMaximo = 5242880; // 5 MB

    private $extensionesPermitidas = ["pdf", "jpg", "png"];

    private $mimesPermitidos = [
        "pdf" => "application/pdf",
        "jpg" => "image/jpeg",
        "png" => "image/png"
    ];

    public function __construct($directorio) {
        $this->directorio = rtrim($directorio, "/");
    }

    public function subir($archivo) {

        if (!is_dir($this->directorio)) {
            return "La carpeta uploads no existe.";
        }

        if (!isset($archivo) || $archivo["error"] != 0) {
            return "No se pudo subir el archivo.";
        }

        if ($archivo["size"] > $this->tamanoMaximo) {
            return "El archivo supera el tamaño máximo permitido de 5 MB.";
        }

        $nombreOriginal = $archivo["name"];
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        if (!in_array($extension, $this->extensionesPermitidas)) {
            return "Solo se permiten archivos PDF, JPG y PNG.";
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if (!$finfo) {
            return "No se pudo validar el tipo del archivo.";
        }

        $mimeReal = finfo_file($finfo, $archivo["tmp_name"]);
        finfo_close($finfo);

        if ($mimeReal != $this->mimesPermitidos[$extension]) {
            return "El tipo real del archivo no es válido.";
        }

        if (!is_uploaded_file($archivo["tmp_name"])) {
            return "El archivo no es válido.";
        }

        $nombreNuevo = "archivo_" . uniqid() . "." . $extension;
        $rutaDestino = $this->directorio . "/" . $nombreNuevo;

        if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
            return "Archivo subido correctamente.";
        } else {
            return "No se pudo guardar el archivo.";
        }
    }

    public function listar() {
        $archivos = [];

        if (!is_dir($this->directorio)) {
            return $archivos;
        }

        $lista = scandir($this->directorio);

        foreach ($lista as $archivo) {

            if ($archivo == "." || $archivo == ".." || $archivo == ".htaccess") {
                continue;
            }

            $ruta = $this->obtenerRutaSegura($archivo);

            if ($ruta != false) {
                $archivos[] = [
                    "nombre" => $archivo,
                    "tamano" => $this->formatearTamano(filesize($ruta)),
                    "fecha" => date("d/m/Y H:i", filemtime($ruta))
                ];
            }
        }

        return $archivos;
    }

    public function eliminar($nombre) {
        $ruta = $this->obtenerRutaSegura($nombre);

        if ($ruta == false) {
            return "Archivo no válido o no encontrado.";
        }

        if (unlink($ruta)) {
            return "Archivo eliminado correctamente.";
        } else {
            return "No se pudo eliminar el archivo.";
        }
    }

    public function obtenerRutaSegura($nombre) {

        if (empty($nombre)) {
            return false;
        }

        if ($nombre != basename($nombre)) {
            return false;
        }

        if (strpos($nombre, "..") !== false) {
            return false;
        }

        if (strpos($nombre, "archivo_") !== 0) {
            return false;
        }

        $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

        if (!in_array($extension, $this->extensionesPermitidas)) {
            return false;
        }

        if (!preg_match("/^[a-zA-Z0-9_.-]+$/", $nombre)) {
            return false;
        }

        $ruta = $this->directorio . "/" . $nombre;

        if (!file_exists($ruta) || !is_file($ruta)) {
            return false;
        }

        return $ruta;
    }

    private function formatearTamano($bytes) {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . " MB";
        } else {
            return round($bytes / 1024, 2) . " KB";
        }
    }
}

?>