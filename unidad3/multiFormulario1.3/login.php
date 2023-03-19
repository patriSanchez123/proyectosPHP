<?php
// index.php
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Parametros de la conexion en la base datos
session_start();
$parametros=array('host'=>'localhost',
                'nombre'=>'root',
                'contrasenia'=>'',
                'baseDeDatos'=>'ejtienda');
                $mensaje="";
//Realizamos la conexion con la base de datos

$conexion=conectar($parametros);

//echo gettype($conexion);

//Se comprueba si existe la sesion y se manda a formulario
if(isset($_SESSION['logadoCliente'])){

    header("Location: ./formulario.php");
    exit();

}else{

//Si no existe la sesion se comprueba la conexion y si existen las variables post
if($conexion){ 
    if((isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario']))&&
        (isset($_POST['contraseniaUsuario'])) && !empty($_POST['contraseniaUsuario'])){

//Comprueba si los usuarios y contraseña son correctos e inicializa la sesion y manda a formulario php
            if(comprobarUsuarioContrasenia($conexion)){

                $_SESSION['logadoCliente']=true;
            
            header("Location: ./formulario.php");
            exit();
                
            }else{
            //si no es correcta el usuario manda mensaje de error
                $mensaje='El usuario o la contraseña no son correctos';                
            }
        }
    if(((isset($_POST['nombreUsuario']) && empty($_POST['nombreUsuario']))) ||
        ((isset($_POST['contraseniaUsuario'])) && empty($_POST['contraseniaUsuario']))){
            $mensaje="Tienes que introducir usuario y contraseña";
            }

        $conexion->close();
        }
        }
    
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
       <label for="nombre">Nombre usuario</label> <input type="text" name="nombreUsuario" id="=nombre"></label><br>
        <label for="contrasenia">Contraseña</label><input type="password" name="contraseniaUsuario" id="contrasenia"></label><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <strong><?php echo $mensaje?></strong>
</body>
</html>
