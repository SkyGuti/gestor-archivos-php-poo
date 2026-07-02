# Gestor de Archivos con PHP y POO

Este proyecto es un sistema web sencillo para gestionar archivos de forma segura usando PHP, Programación Orientada a Objetos y base de datos MySQL.

El sistema permite iniciar sesión, subir archivos, listar los archivos guardados, descargarlos y eliminarlos según el rol del usuario.

El usuario administrador puede subir, descargar y eliminar archivos. El usuario normal puede subir y descargar archivos, pero no puede eliminar.

Los archivos permitidos son PDF, JPG y PNG. El sistema valida la extensión, el tipo real del archivo y el tamaño máximo permitido antes de guardarlo.

## Herramientas usadas

- HTML5
- CSS
- PHP
- Programación Orientada a Objetos
- MySQL
- phpMyAdmin
- XAMPP
- Apache

## Estructura del proyecto

```text
gestor_archivos/
├── uploads/
│   └── .htaccess
├── .htaccess
├── auth.php
├── conexion.php
├── database.sql
├── descargar.php
├── eliminar.php
├── estilos.css
├── GestorArchivos.php
├── index.php
├── login.php
├── logout.php
├── README.md
├── subir.php
└── validar_login.php
```

## Instalación

1. Copiar la carpeta `gestor_archivos` dentro de la carpeta `htdocs` de XAMPP.

```text
C:\xampp\htdocs\gestor_archivos
```

2. Abrir XAMPP y activar Apache y MySQL.

3. Entrar a phpMyAdmin desde el navegador.

```text
http://localhost/phpmyadmin
```

4. Importar el archivo `database.sql`.

Este archivo crea la base de datos, la tabla de usuarios y los usuarios de prueba.

5. Abrir el sistema desde el navegador.

```text
http://localhost/gestor_archivos/login.php
```

## Datos de acceso

Administrador:

```text
Usuario: admin
Contraseña: admin123
```

Usuario normal:

```text
Usuario: usuario
Contraseña: usuario123
```

## Funcionamiento

Después de iniciar sesión, el sistema muestra un panel principal donde se pueden subir archivos.

Los archivos subidos aparecen en una tabla con la siguiente información:

- Nombre del archivo
- Tamaño
- Fecha de subida
- Botón para descargar
- Botón para eliminar, solo si el usuario es administrador

Para salir del sistema se usa el botón `Cerrar sesión`.

## Clase principal

La clase principal del proyecto se llama `GestorArchivos` y se encuentra en el archivo `GestorArchivos.php`.

Esta clase se encarga de manejar las acciones principales relacionadas con los archivos.

Métodos principales:

- `subir($archivo)`: valida y guarda el archivo.
- `listar()`: muestra los archivos subidos.
- `eliminar($nombre)`: elimina un archivo de forma segura.
- `obtenerRutaSegura($nombre)`: valida que el archivo sea válido antes de descargarlo o eliminarlo.

## Seguridad aplicada

El proyecto incluye las siguientes medidas de seguridad:

- Inicio de sesión con base de datos.
- Uso de sesiones para proteger el panel.
- Contraseñas cifradas con `password_hash()`.
- Validación de contraseña con `password_verify()`.
- Consultas preparadas para evitar inyección SQL.
- Manejo de roles de usuario.
- Solo el administrador puede eliminar archivos.
- Validación de extensión del archivo.
- Validación del tipo MIME real con `finfo_file()`.
- Solo se permiten archivos PDF, JPG y PNG.
- Tamaño máximo permitido de 5 MB.
- Renombrado automático del archivo antes de guardarlo.
- Validación del nombre del archivo antes de descargar o eliminar.
- Protección contra rutas peligrosas como `../archivo`.
- Uso de `htmlspecialchars()` al mostrar datos.
- Protección de la carpeta `uploads` con `.htaccess`.
- Bloqueo del acceso directo a los archivos subidos.
- Descarga de archivos mediante `descargar.php`.
- Bloqueo de ejecución de archivos PHP dentro de `uploads`.

## Protección de uploads

La carpeta `uploads` está protegida para evitar que se pueda acceder directamente desde el navegador.

Si se intenta abrir esta ruta:

```text
http://localhost/gestor_archivos/uploads/
```

el servidor debe mostrar:

```text
403 Forbidden
```

Esto significa que la carpeta está protegida y que los archivos solo se manejan desde el sistema.

## Autor

Sky Gutiérrez
