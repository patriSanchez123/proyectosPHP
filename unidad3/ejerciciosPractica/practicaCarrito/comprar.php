<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once('./funciones.inc.php');
session_start();

$parametrosConexion = array(
    'host' => 'localhost',
    'usuario' => 'root',
    'contrasena' => "",
    'bbdd' => 'ejtienda'
);

if(!isset($_SESSION['logadoCliente'])){
    header("Location: ./login.php");
    exit();
}
if(!isset($_SESSION['cesta'])){
    header("Location: ./productos.php");
    exit();
}else{
    $conexion = conectar($parametrosConexion['host'], $parametrosConexion['usuario'], $parametrosConexion['contrasena'], $parametrosConexion['bbdd']);
    if(isset($_POST['eliminar'])){
        borraArticulo($_POST['eliminar'],$_POST['cantidad'],$_SESSION['cesta']);
    }
    if(isset($_POST['atras'])){
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
    <title>Comprar</title>
    <link rel="stylesheet" href="./css/estilo.css">
</head>
<body>
<?php imprimirCesta($conexion,$_SESSION['cesta']);?>
</body>
</html>