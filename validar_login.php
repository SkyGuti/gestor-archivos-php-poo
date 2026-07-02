<?php

session_start();

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = trim($_POST["usuario"]);
    $clave = trim($_POST["clave"]);

    if (empty($usuario) || empty($clave)) {
        $mensaje = urlencode("Debe ingresar usuario y contraseña.");
        header("Location: login.php?error=" . $mensaje);
        exit();
    }

    $stmt = $conexion->prepare("SELECT id, nombre, usuario, clave, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {

        $datos = $resultado->fetch_assoc();

        if (password_verify($clave, $datos["clave"])) {

            $_SESSION["id"] = $datos["id"];
            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["rol"] = $datos["rol"];

            header("Location: index.php");
            exit();

        } else {
            $mensaje = urlencode("Usuario o contraseña incorrectos.");
            header("Location: login.php?error=" . $mensaje);
            exit();
        }

    } else {
        $mensaje = urlencode("Usuario o contraseña incorrectos.");
        header("Location: login.php?error=" . $mensaje);
        exit();
    }

    $stmt->close();
    $conexion->close();

} else {
    header("Location: login.php");
    exit();
}

?>