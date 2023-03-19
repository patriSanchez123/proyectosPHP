<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reiniciar base de datos</title>
</head>
<body>
<?php  
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once('./config.inc.php');
    $retval=array();
    $errorExec=array();

    @ $conexion= new mysqli('localhost', 'root', '');
    
    $error=$conexion->connect_errno;

    if($error !=0){

        echo '<span style="color:red">Error en la conexión el la base de datos</span>';
        echo $conexion->connect_error;

    }
    else{

    if(isset($_GET['reiniciar'])){
        
       
  /**
   * exec es una función que realiza una sentencia en la terminal.Incluye dos variables para el control
   * de errores,$retval retorna la última linea de la sentencia,$errorExec retorna true si ocurre un error
   */       
      exec('cd '.$configuracion['ruta archivo'].' && '.$configuracion['ruta destino']. ' -u root < '.$configuracion['nombre archivo'],$retval,$errorExec);
    }
    //Si es true indica que ha ocurrido un problema al insertar la base de datos
    if($errorExec){

        echo '<span style="color:red">Ha dado un error al insertar la base de datos</span>';
    }
    
?>
    
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
    <input type="submit" value="Reiniciar base de datos" name="reiniciar">
    </form>
    <?php 
    $conexion->close();
    }
    ?>
</body>
</html>