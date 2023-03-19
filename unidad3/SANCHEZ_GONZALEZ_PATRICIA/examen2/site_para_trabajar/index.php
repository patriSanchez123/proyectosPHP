<?php
  session_start();
  
  
  require_once('./productos.php');
  require_once('./funciones.php');
  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  //Aquí puedes inicializar, si procede, la variable de sesión de la cesta
  //La estructura de la cesta puede ser simplemente un array cuyas claves se correspondan a los identificadores de los productos y cuyo valor sea el número de unidades de ese producto en la cesta
  //Puedes sacar el resto de la información cruzando la información de la cesta con el array producto 
  
  //Aquí puedes gestionar los post. Hay dos funcionalidades en la página (dos formularios): add_to_cart, y update_cart_button (actualizar unidades). La manera de sacar los productos de la cesta es poner a 0 el número de unidades que hay en la cesta y pulsar "UPDATE"
  
  if(!isset($_SESSION['cesta'])){

    $_SESSION['cesta']=array();

  }else{

    if(isset($_POST['nombre']) || isset($_POST['nombreL'])){
      
      aniadirCesta($_SESSION['cesta'],$_POST['nombre']);

      print_r($_SESSION['cesta']);

    }
    elseif (isset($_POST['update_cart_button']) && !empty ($_POST['cantidad'])){
      print_r($_SESSION['cesta']);
      print_r($_POST['cantidad']);

      modidicarCantidadProducto($_SESSION['cesta'],$_POST['cantidad']);
    }
  }

    

 

  $the_basket = getBasketMarkup();
  $the_products = getProductosMarkup();
  include('./home.tpl.php'); 
?>
