<?php
//comprobación de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  session_start();
  
  
  require_once('./productos.php');
  require_once('./funciones.php');

//comprobamos que exista la sesión cesta , si no existe se crea
  if(!isset($_SESSION['cesta'])){
    $_SESSION['cesta']=array();
    //Inicicializamos la cesta con los articulos a 0
    iniCesta($_SESSION['cesta']);
  }
//si existe incluir cesta se le añade +1 a a la variable  cesta
      if(isset($_POST['incluirCesta'])){
        //función que añade productos a la cesta
        incluir($_SESSION['cesta'],$_POST['incluirCesta']);

      }
      elseif(isset($_POST['restarArticulos'])){

      //función que resta los articulos de la cesta
        restarArticulos($_SESSION['cesta'],$_POST['restarArticulos']);
      }

  
  //Aquí puedes inicializar, si procede, la variable de sesión de la cesta
  //La estructura de la cesta puede ser simplemente un array cuyas claves se correspondan a los identificadores de los productos y cuyo valor sea el número de unidades de ese producto en la cesta
  //Puedes sacar el resto de la información cruzando la información de la cesta con el array producto 
  

  //Aquí puedes gestionar los post. Hay varias funcionalidades en la página (dos formularios): incluir en cesta, subir un determinado producto en una unidad y bajar un determinado producto de la cesta en una unidad. La manera de sacar los productos de la cesta es poner a 0 el número de unidades que hay en la cesta
  $the_basket = getBasketMarkup();
  $the_products = getProductosMarkup();
  include('./home.tpl.php'); 
?>
