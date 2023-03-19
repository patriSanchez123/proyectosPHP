<?php 
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$parametros=array('host'=>'localhost',
                'nombre'=>'root',
                'contrasenia'=>'',
                'baseDeDatos'=>'ejtienda');
                $mensaje="";

session_start();

if(!isset($_SESSION['logadoCliente'])){
    header("Location: ./login.php");
            exit();
    
}else{

//inicializamos la sesion de los productos
if(!isset($_SESSION['datosFormularios']['producto'])||empty($_SESSION['datosFormularios']['producto'])){

    $_SESSION['datosFormularios']=array(
        'producto'=>array(),
        'pasoActual'=>0 );

    insersionProductosSesion($parametros,4,1,$_SESSION['datosFormularios']['producto']);
        

}


    if(isset($_POST['atras'])){
        $_SESSION['datosFormularios']['pasoActual'] =  $_SESSION['datosFormularios']['pasoActual']-1;
    }else if(isset($_POST['siguiente'])){
        aniadirCantidad($_SESSION['datosFormularios'],$_POST['cantidad']);
        //$_SESSION['formulario']['productos'][$_SESSION['formulario']['paso_actual']]['cantidad'] = $_POST['cantidad'];
        $_SESSION['datosFormularios']['pasoActual'] =  $_SESSION['datosFormularios']['pasoActual']+1;
        
        print_r($_SESSION['datosFormularios']['producto'][0]['infoProducto']);  
    }else if(isset($_POST['comprar'])){
        aniadirCantidad($_SESSION['datosFormularios'],$_POST['cantidad']);
        $_SESSION['datosFormularios']['pasoActual'] =  $_SESSION['datosFormularios']['pasoActual']+1;
        
        header("Location: ./comprar.php");
         exit();

    }

        //print_r($_SESSION['datosFormularios']['producto']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo.css">
    <title>Formulario Multipasos</title>
</head>
<body>
    <?php 
     //echo '<h2>'.$_SESSION['datosFormularios']['producto'][$_SESSION['datosFormularios']['pasoActual']]['infoProducto']['nombre'].'</h2><br>';
     //echo'<p>Precio: '. $_SESSION['datosFormularios']['producto'][$_SESSION['datosFormularios']['pasoActual']]['infoProducto']['precio'].'€</p>';
    echo imprimirFormulario($_SESSION['datosFormularios']); 
    //echo calcularTotal($_SESSION['datosFormularios'])
    ?>
    
</body>
</html>
<?php }?>