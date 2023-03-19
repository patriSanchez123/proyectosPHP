<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
// Si el usuario aún no se ha autentificado, pedimos las credenciales
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Contenido restringido"');
    header("HTTP/1.0 401 Unauthorized");
    exit;
}
// Si ya ha enviado las credenciales, las comprobamos con la base de datos
else {
    // Conectamos a la base de datos
    @$dwes = new mysqli("localhost", "root", "", "ejtienda");
    $error = $dwes->connect_errno;
    // Si se estableció la conexión
    if ($error == null) {
        // Ejecutamos la consulta para comprobar si existe
        // esa combinación de usuario y contraseña
        $sql = "SELECT usuario FROM usuarios
 WHERE usuario='$_SERVER[PHP_AUTH_USER]' AND
 contrasena='$_SERVER[PHP_AUTH_PW]'";
        $resultado = $dwes->query($sql);
        // Si no existe, se vuelven a pedir las credenciales
        if ($resultado->num_rows == 0) {
            header('WWW-Authenticate: Basic realm="Contenido restringido"');
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
        $resultado->close();
        $dwes->close();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">
<!-- Desarrollo Web en Entorno Servidor -->
<!-- Tema 4 : Desarrollo de aplicaciones web con PHP -->
<!-- Ejemplo: Utilización de MySQL para autentificación HTTP -->
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Ejemplo Tema 4: Utilización de MySQL para autentificación HTTP</title>
    <link href="dwes.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
    echo "Nombre de usuario: " . $_SERVER['PHP_AUTH_USER'] . "<br />";
    echo "Hash de la contraseña: " . $_SERVER['PHP_AUTH_PW'] . "<br />";
    ?>
</body>

</html>