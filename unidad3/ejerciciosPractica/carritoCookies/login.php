<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once('./funciones.inc.php');

    $parametrosConexion=array('host'=>'localhost',
                            'usuario'=>'root',
                            'contrasena'=>"",
                            'bbdd'=>'ejtienda');
    $error="";
    
   
    if(isset($_COOKIE['logadoCliente'])){
        header("Location: ./productos.php");
            exit();
    }    
    else{
        
    
        $conexion=conectar($parametrosConexion['host'],$parametrosConexion['usuario'],$parametrosConexion['contrasena'],$parametrosConexion['bbdd']);
   
        if(!comprobarLogin($conexion,$_POST['nombre'],$_POST['contrasena'])){
            $error='<p><strong>El usuario o la contraseña no son correctos</strong></p>';
        }else{
            setcookie('logadoCliente','true');
            setcookie('paginaActual',1);
            inicializarCesta($conexion);
            header("Location: ./productos.php");
            exit();
        
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
    <?php echo $error?>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="nombre">Nombre</label><input type="text" id="nombre" name="nombre"><br>
    <label for="contrasena">Contraseña</label><input type="password" id="contrasena" name="contrasena"><br>
    <input type="submit" name="enviar" Value="Enviar">
</form>
</body>
</html>