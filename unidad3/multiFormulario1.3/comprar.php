<?php 
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if(!isset($_SESSION['datosFormularios']['producto'])||empty($_SESSION['datosFormularios']['producto'])){

    header("Location: ./formulario.php");
    exit();

}elseif(!isset($_SESSION['logadoCliente'])){

    header("Location: ./login.php");
    exit();

}elseif(isset($_SESSION['datosFormularios']['producto'])||!empty($_SESSION['datosFormularios']['producto'])){


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo.css">
    <title>Cesta productos</title>
</head>
<body>
<?php 
        echo mostrarCesta($_SESSION['datosFormularios']);
        echo imprimirFormulario($_SESSION['datosFormularios']);?>  
</body>
</html>
<?php }?>