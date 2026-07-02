<?php
session_start();

if (isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

$mensaje = "";
$claseMensaje = "mensaje-error";

if (isset($_GET["error"])) {
    $mensaje = $_GET["error"];
    $claseMensaje = "mensaje-error";
}

if (isset($_GET["mensaje"])) {
    $mensaje = $_GET["mensaje"];
    $claseMensaje = "mensaje";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestor de Archivos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css?v=61">
</head>
<body>

    <header class="barra">
        <h1>Gestor de Archivos</h1>
    </header>

    <main>
        <section class="contenedor-login">
            <h2>Iniciar sesión</h2>
            <p>Ingresa tu usuario y contraseña para acceder al sistema.</p>

            <?php if (!empty($mensaje)) { ?>
                <div class="<?php echo $claseMensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php } ?>

            <form action="validar_login.php" method="POST">

                <div class="grupo">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>

                <div class="grupo">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required>
                </div>

                <button type="submit">Ingresar</button>

            </form>
        </section>
    </main>

    <footer>
        <p>Proyecto PHP con POO, base de datos y seguridad en archivos</p>
    </footer>

</body>
</html>