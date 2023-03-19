
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar tabla</title>
    <link rel="stylesheet" href="./css/estilo.css">
</head>
<body>
<?php 
require_once('./funciones.inc.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $datosConexion=array();
    if(isset($_POST['mostrar'])&&(isset($_POST['host']) && !empty($_POST['host'])) && 
    (isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario'])) && 
     (isset($_POST['base']) && !empty($_POST['base']))){

    $conexion=conectar($_POST['host'],$_POST['nombreUsuario'],$_POST['pass'],$_POST['base']);
    $error=$conexion->connect_errno;
    if($error !=0){
        echo '<p>Error al conectar la base de datos</p>';
        echo $error;
        exit();
    }
    else{?>
        <?php echo '<p>Se ha conectado correctamente</p>';
        
        mostrarTabla($conexion);
        $conexion->close();
        
     }
     
    }
   
?>
 <br>
     <form action="./index.php" method="post">
        <input type="submit" name="paginaPrincipal" value="Volver">
     </form>


</body>
</html>
 