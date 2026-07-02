<?php
include("auth.php");

define('APP_RUNNING', true);
require_once "GestorArchivos.php";

$gestor = new GestorArchivos("uploads");
$archivos = $gestor->listar();

$mensaje = "";

if (isset($_GET["mensaje"])) {
    $mensaje = $_GET["mensaje"];
}

$nombreUsuario = "Usuario";
$rolUsuario = "usuario";

if (isset($_SESSION["nombre"])) {
    $nombreUsuario = $_SESSION["nombre"];
}

if (isset($_SESSION["rol"])) {
    $rolUsuario = $_SESSION["rol"];
}

$esAdmin = false;

if ($rolUsuario == "admin") {
    $esAdmin = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Archivos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css?v=61">
</head>
<body>

    <header class="barra">
        <h1>Gestor de Archivos</h1>

        <nav>
            <a href="logout.php">Cerrar sesión</a>
        </nav>
    </header>

    <main class="pagina">

        <section class="bienvenida">
            <h2>Panel de archivos</h2>
            <p>
                Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>.
                Rol: <?php echo htmlspecialchars($rolUsuario); ?>.
            </p>
        </section>

        <section class="caja">
            <h2>Subir archivo</h2>
            <p>Solo se permiten archivos PDF, JPG y PNG. Tamaño máximo: 5 MB.</p>

            <form action="subir.php" method="POST" enctype="multipart/form-data" onsubmit="return validarArchivo();">
                <div class="grupo">
                    <label for="archivo">Seleccionar archivo</label>
                    <input type="file" id="archivo" name="archivo" onchange="revisarArchivo();">
                </div>

                <div id="mensajeArchivo" class="mensaje" style="display: none;"></div>

                <?php if (!empty($mensaje)) { ?>
                    <div class="mensaje">
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php } ?>

                <button type="submit">Subir archivo</button>
            </form>
        </section>

        <section class="caja">
            <h2>Archivos subidos</h2>

            <?php if (count($archivos) > 0) { ?>
                <div class="tabla-contenedor">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tamaño</th>
                                <th>Fecha de subida</th>
                                <th>Descargar</th>

                                <?php if ($esAdmin) { ?>
                                    <th>Eliminar</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($archivos as $archivo) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($archivo["nombre"]); ?></td>
                                    <td><?php echo htmlspecialchars($archivo["tamano"]); ?></td>
                                    <td><?php echo htmlspecialchars($archivo["fecha"]); ?></td>

                                    <td>
                                        <a class="btn-descargar" href="descargar.php?archivo=<?php echo urlencode($archivo["nombre"]); ?>">
                                            Descargar
                                        </a>
                                    </td>

                                    <?php if ($esAdmin) { ?>
                                        <td>
                                            <a class="btn-eliminar"
                                               href="eliminar.php?archivo=<?php echo urlencode($archivo["nombre"]); ?>"
                                               onclick="return confirm('¿Seguro que deseas eliminar este archivo?');">
                                                Eliminar
                                            </a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p class="sin-archivos">Todavía no hay archivos subidos.</p>
            <?php } ?>
        </section>

    </main>

    <footer>
        <p>Proyecto PHP con POO, base de datos y seguridad en archivos</p>
    </footer>

    <script>
        function revisarArchivo() {
            var archivo = document.getElementById("archivo");
            var mensaje = document.getElementById("mensajeArchivo");

            mensaje.style.display = "none";
            mensaje.innerHTML = "";

            if (archivo.files.length == 0) {
                return true;
            }

            var nombre = archivo.files[0].name.toLowerCase();
            var partes = nombre.split(".");
            var extension = partes[partes.length - 1];

            if (extension != "pdf" && extension != "jpg" && extension != "png") {
                mensaje.innerHTML = "Archivo no permitido. Solo se permiten archivos PDF, JPG y PNG.";
                mensaje.style.display = "block";
                archivo.value = "";
                return false;
            }

            return true;
        }

        function validarArchivo() {
            var archivo = document.getElementById("archivo");
            var mensaje = document.getElementById("mensajeArchivo");

            mensaje.style.display = "none";
            mensaje.innerHTML = "";

            if (archivo.files.length == 0) {
                mensaje.innerHTML = "Debe seleccionar un archivo.";
                mensaje.style.display = "block";
                return false;
            }

            return revisarArchivo();
        }
    </script>

</body>
</html>