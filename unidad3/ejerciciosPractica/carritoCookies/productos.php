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
$pagActual=1;

if (!isset($_COOKIE['logadoCliente'])) {
    header("Location: ./login.php");
    exit();
} else {
    $conexion = conectar($parametrosConexion['host'], $parametrosConexion['usuario'], $parametrosConexion['contrasena'], $parametrosConexion['bbdd']);
    if ((!isset($_COOKIE['paginaActual'])) || (empty($_COOKIE['paginaActual']))) {
        echo 'entra';
        //setcookie('paginaActual',1);
        //inicializarCesta($conexion);
    }
    //print_r($_COOKIE);
    
    print_r($_COOKIE);
    if (isset($_POST['atras'])) {
        $pagActual=$_COOKIE['paginaActual']-1;
        $_COOKIE['paginaActual'] = setcookie('paginaActual',$pagActual);
        echo $_COOKIE['paginaActual'];
    }
    if (isset($_POST['siguiente'])) {
        $pagActual=$_COOKIE['paginaActual']+1;
        insertarTodaPagina($_POST['cantidad']);
       $_COOKIE['paginaActual'] = setcookie('paginaActual',$pagActual);
      
    }
     if(isset($_POST['agregarCesta'])){
         aniadirACarrito($_POST['agregarCesta'], $_POST['cantidad']);
         header("Location: ./productos.php");
     }
    if (isset($_POST['comprar'])) {
        echo 'entra';
        insertarTodaPagina($_POST['cantidad']);
        header("Location: ./comprar.php");
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
    <title>Lista Producto</title>
    <link rel="stylesheet" href="./css/estilo.css">
</head>

<body>
    <?php
     echo $_COOKIE['paginaActual'];
     formularioProductos($conexion,11, $pagActual); ?>
</body>

</html>