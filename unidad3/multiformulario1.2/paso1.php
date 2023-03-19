<?php 
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Inicializamos las variables
$params = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' =>'',
    'dbname' =>'ejtienda'
  );
//Variable donde se guarda las claves de la sesion

session_start();
//Si no existe logado de cliente mandamos a login.php
if(!isset($_SESSION['logadoCliente'])){
    header("Location: ./login.php");
    exit();
}else{
//Si todo es correcto comprobamos la conexión a la base de datos
    $conexion=conectar($params);
    $error=$conexion->connect_errno;
    
    if($error!=0){
       //Conexion correcta
       echo 'No se conectado correctamente con el servidor';
       exit();

    }else{
        //si no existe sesion de productos se inicializa con los parametros deseados
        if(!isset($_SESSION['productos']) && !isset($_SESSION['cesta'])){
            $_SESSION['productos']=array();
            $_SESSION['cesta']=array();
            $consulta='SELECT * FROM producto';
            $resultado=$conexion->query($consulta);

            while($producto=$resultado->fetch_array()){
                $_SESSION['productos']+=array($producto['cod']=>0);
                }
        }?>
        
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>paso1</title>
    <link rel="stylesheet" href="./css/estilo.css">
</head>
<body>
    <?php
    //Insersión de datos paso1
    if(isset($_POST['paso1']) || ((!isset($_POST['paso2'])&& !isset($_POST['paso3']) && !isset($_POST['paso3']) && !isset($_POST['paso4'])&& !isset($_POST['verCesta'])))){?>
    <?php paso_1($conexion)?>
    
        <?php
    //Insersión de datos paso2    
    }elseif(isset($_POST['paso2'])){
            echo 'entrado en paso2';?>

<div id="paso2">
        <?php 
        $keys=array_keys($_SESSION['productos']);
        
        foreach($_POST['cantidad'] as $clave =>$valor){ 
            aniadirProductos($clave,$valor);   
        }

        //////Esto tengo que mofificarlo bien con lo de arriba y ponerle un for 
        print_r($_SESSION['productos']);?>
        <p>Inserte la cantidad que desea de este articulo</p>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        for ($i=5; $i < 12; $i++) { 
            $resultado=mostarObjetos($keys[$i],$conexion); ?>
        <label for="<?php echo $keys[$i]?>"><?php echo $resultado['nombre_corto']?>  <input type="number" id="<?php echo $keys[$i]?>" name="cantidad[<?php echo $keys[$i]?>]"></label><br>
        <?php }?>
        <input type="submit" name="paso1" value="Atras">
        <input type="submit" name="paso3" value="Siguiente">
        </form>
    </div>

       <?php 
//////////////////////////////////////////////////////////////////////
    //Insersión de datos paso3
    }elseif(isset($_POST['paso3'])){?>



<div id="paso3">
        <?php 
        $keys=array_keys($_SESSION['productos']);
        
        foreach($_POST['cantidad'] as $clave =>$valor){ 
            aniadirProductos($clave,$valor);   
        }

        //////Esto tengo que mofificarlo bien con lo de arriba y ponerle un for 
        print_r($_SESSION['productos']);?>
        <p>Inserte la cantidad que desea de este articulo</p>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        for ($i=5; $i < 12; $i++) { 
            $resultado=mostarObjetos($keys[$i],$conexion); ?>
        <label for="<?php echo $keys[$i]?>"><?php echo $resultado['nombre_corto']?>  <input type="number" id="<?php echo $keys[$i]?>" name="cantidad[<?php echo $keys[$i]?>]"></label><br>
        <?php }?>
        <input type="submit" name="paso2" value="Atras">
        <input type="submit" name="paso4" value="Siguiente">
        </form>
    </div>




     <?php
    //Insersión de datos paso4
    }elseif(isset($_POST['paso4'])){?>

        <?php 
        $keys=array_keys($_SESSION['productos']);
        aniadirProductos($keys[2],$_POST['cantidad']);
        print_r($_SESSION['productos']);
        $resultado=mostarObjetos($keys[3],$conexion);?>
        <p>Inserte la cantidad que desea de este articulo</p>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="producto1"><?php echo $resultado['nombre_corto']?>  <input type="number" id="producto1" name="cantidad"></label>
        <input type="submit" name="paso3" value="Atras">
        <input type="submit" name="verCesta" value="Ver cesta">
        </form>
    </div>



     <?php }elseif(isset($_POST['verCesta'])){

        $keys=array_keys($_SESSION['productos']);
        aniadirProductos($keys[3],$_POST['cantidad']);
        mostrarCesta($conexion);?>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" name="paso4" value="Atras">
        
        </form>
        



    <?php }?>
    
</body>
</html>        


    



   <?php }
   }
   ?>









