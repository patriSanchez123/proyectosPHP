<?php
// index.php
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$params = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'ejtienda'
);
//si el cliente está logado redirige a productos
if (isset($_SESSION['logadoCliente'])) {

    header("Location: ./productos.php");
    exit();
} else {
    //si existe nombre y contraseña y están llenas comprueba conexion y hace consulta a la base de datos si se encuentran
    //el usuario y la contraseña en la base de datos
    if (isset($_POST['nombre']) && !empty($_POST['nombre']) && isset($_POST['contrasenia']) && !empty($_POST['contrasenia'])) {
        $conexion = conectar($params);
        $error = $conexion->connect_errno;

        if ($error == 0) {
            //Comprobar usuario 
            $consulta = 'SELECT * FROM usuarios WHERE usuario=\'' . $_POST['nombre'] . '\' AND contrasena=\'' . $_POST['contrasenia'] . '\'';
            $resultado = $conexion->query($consulta);
            $contador = $resultado->num_rows;

            if ($contador > 0) {
                echo 'Por favor entra';
                $_SESSION['logadoCliente'] = true;
                header("Location: ./productos.php");
                exit();
                $conexion->close();
            } else {
                echo '<p>El usuario y contraseña no son correcto</p>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>


    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <label for="nombre">Nombre<input type="text" id="nombre" name="nombre"></label>
        <label for="contrasenia">Contraseña<input type="text" id="contrasenia" name="contrasenia"></label>
        <input type="submit" value="Enviar" name="enviar">
    </form>
</body>

</html>