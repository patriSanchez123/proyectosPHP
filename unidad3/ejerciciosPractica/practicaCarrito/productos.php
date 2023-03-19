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

if (!isset($_SESSION['logadoCliente'])) {
    header("Location: ./login.php");
    exit();
} else {
    $conexion = conectar($parametrosConexion['host'], $parametrosConexion['usuario'], $parametrosConexion['contrasena'], $parametrosConexion['bbdd']);
    if ((!isset($_SESSION['cesta'])) || (empty($_SESSION['cesta']))) {
        $_SESSION['cesta'] = array();
        $_SESSION['paginaActual'] = 1;
        inicializarCesta($conexion, $_SESSION['cesta']);
    }
    if (isset($_POST['atras'])) {

        $_SESSION['paginaActual'] = $_SESSION['paginaActual'] - 1;
    }
    if (isset($_POST['siguiente'])) {
        insertarTodaPagina($_POST['cantidad'],$_SESSION['cesta']);
        $_SESSION['paginaActual'] = $_SESSION['paginaActual'] + 1;
    }
    if(isset($_POST['agregarCesta'])){
        aniadirACarrito($_POST['agregarCesta'], $_POST['cantidad'],$_SESSION['cesta']);
    }
    if (isset($_POST['comprar'])) {
        insertarTodaPagina($_POST['cantidad'],$_SESSION['cesta']);
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
    formularioProductos($conexion, 5, $_SESSION['paginaActual'], $_SESSION['cesta']); ?>
</body>

</html>