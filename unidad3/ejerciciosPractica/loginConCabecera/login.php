<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once('./funciones.inc.php');

$parametrosConexion=array('host'=>'localhost',
'usuario'=>'root',
'contrasena'=>"",
'bbdd'=>'ejtienda');
$error="";
$conexion=conectar($parametrosConexion['host'],$parametrosConexion['usuario'],$parametrosConexion['contrasena'],$parametrosConexion['bbdd']);
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Contenido restringido"');
    header("HTTP/1.0 401 Unauthorized");
    exit;
}else{
        if(!comprobarLogin($conexion,$_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])){
            $error='<p><strong>El usuario o la contraseña no son correctos</strong></p>';
            header('WWW-Authenticate: Basic realm="Contenido restringido"');
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php echo $error;
    
    echo "Nombre de usuario: " . $_SERVER['PHP_AUTH_USER'] . "<br />";
    echo "Hash de la contraseña: " . $_SERVER['PHP_AUTH_PW'] . "<br />";
    ?>
    
</form>
</body>
</html>