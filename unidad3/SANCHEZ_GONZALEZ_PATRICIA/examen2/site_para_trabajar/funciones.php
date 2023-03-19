<?php

require_once("./productos.php");

/** La siguiente función debe generar el código HTML de la cesta, y su formulario asociado
 * Ten presente los ámbitos de las variables y los modificadores que puedes utilizar para cambiarlo
 */
function getBasketMarkup(){
  global $productos;
  //Ejemplo del HTML generado: ( no tiene por qué coincidir exactamente con el presente en la plantilla HTML )
  $basket_markup="";
 //<!-- RD Navbar Basket-->
   $basket_markup.='<div class="rd-navbar-basket-wrap">
    <button class="rd-navbar-basket fl-bigmug-line-shopping198" data-rd-navbar-toggle=".cart-inline"><span>'.contarProductosCesta($_SESSION['cesta']).'</span></button>
    <form action="./index.php" method="post">

    <div class="cart-inline">
      <div class="cart-inline-header">
        <h5 class="cart-inline-title">In cart:<span>'.contarProductosCesta($_SESSION['cesta']).'</span> Products</h5>
        <h6 class="cart-inline-title">Total price:<span> $'.precioTotalCesta($_SESSION['cesta']).'</span></h6>
      </div>';

//Recorremos la cesta imprimir los datos en el formulario y comprobamos esos datos con los de productos 
//para poder imprimir los datos de los productos
    foreach($_SESSION['cesta'] as  $clave =>$valor){
      foreach($productos as $valorProducto){
        
        if(($clave==$valorProducto['nombre'])){

          $basket_markup.='<div class="cart-inline-body"><div class="cart-inline-item">
          <div class="unit align-items-center">
            <div class="unit-left"><img src="'.$valorProducto['img_miniatura'].'" alt="Foto" width="108" height="100"/></div>
            <div class="unit-body">
              <h6 class="cart-inline-name">'.$valorProducto['nombre'].'</h6>
              <div>
                <div class="group-xs group-inline-middle">
                  <div class="table-cart-stepper">
                    <input class="form-input" type="number" data-zeros="true" value="'.$valor.'" min="0" max="1000" name="cantidad['.$valorProducto['nombre'].']">
                  </div>
                  <h6 class="cart-inline-title">$'.$valorProducto['precio'].'</h6>
                </div>
              </div>
            </div>
          </div>  
      </div>';


        }


      
    }
     
      
    }
      $basket_markup.= '<div class="cart-inline-body"><div class="cart-inline-item">
      <div class="cart-inline-footer">
        <div class="group-sm"><a class="button button-md button-default-outline-2 button-wapasha" href="./index.php">Go to cart</a>
        <input type="submit" style="background-color: #3c6a36;" class="button button-md button-primary button-pipaluk" value="update" name="update_cart_button" ></div>
        </div>
    </div>
    </form>
  </div><a class="rd-navbar-basket rd-navbar-basket-mobile fl-bigmug-line-shopping198" href="#"><span>4</span></a>';
   
    return $basket_markup;
  }

/** La siguiente función debe generar el código HTML de los productos, con sus botones de 'add to cart' cesta
 * Ten presente los ámbitos de las variables y los modificadores que puedes utilizar para cambiarlo
 */
  function getProductosMarkup(){
    //ponemos como global la variable
    global $productos;
    $productos_markup="";
    
   //Ejemplo del HTML generado: ( no tiene por qué coincidir exactamente con el presente en la plantilla HTML )
   $productos_markup='';
   $productos_markup='<div class="col-md-5 col-lg-6"><form method="post" action="./index.php">
      <div class="row row-30 justify-content-center"><div class="col-sm-6 col-md-12 col-lg-6">
      <div class="oh-desktop">
        <!-- Product-->';

    /**
     * realiza buble para que se muestre la informacion de todos los articulos
     */
    foreach($productos as $clave => $valor){


      $productos_markup.='<article class="product product-2 box-ordered-item wow slideInRight" data-wow-delay="0s">
          <div class="unit flex-row flex-lg-column">
            <div class="unit-left">
              <div class="product-figure"><img src="'.$valor['img_url'].'" alt="Foto" width="270" height="280" name="'.$valor['nombre'] .'"/>
              <div class="product-button"><input type="submit" class="button button-md button-white button-ujarak" value="Add to cart" name="nombre['.$valor['nombre'].']" ></div>
            </div>
          </div>
          <div class="unit-body">
            <h6 class="product-title"><a href="./index.php">'.$valor['nombre'] .'</a></h6>
            <div class="product-price-wrap">
              <div class="product-price">$'.$valor['precio'] .'</div>
            </div><!--<a class="button button-sm button-secondary button-ujarak" href="#">Add to cart</a>--><input type="submit" class="button button-sm button-secondary button-ujarak" value="Add to cart" name="nombre['.$valor['nombre'].']" >
          </div>
        </div>
      </article>
      </div>
  </div><div class="col-sm-6 col-md-12 col-lg-6">
      <div class="oh-desktop">';



    }

    $productos_markup.= ' </form></div>';
    return $productos_markup;
  }

  /***
   * Función añadir a la funcion cesta
   */
  function aniadirCesta(&$cesta,$nombre){
    //sacamos el key de la cesta para poder añadirle el nombre a la sesion
    $keys=array_keys($nombre);
    $key=$keys[0];
    //Lo inicializo a 1 por que en principio no puede decir cuantos productos son
    $cantidadCesta=1;
    //Esta variable sirve para comprobar los datos que esten dentro de la cesta no se repitan
    $keysCesta=array_keys($cesta);

    if(!in_array($nombre,$keysCesta)){
      $cesta+=array($key=>$cantidadCesta);

    }
  }
  
  /**
   * Funcion que cuenta los productos totales que hay en la cesta
   */
  function contarProductosCesta($cesta){
    $total=0;
    foreach($cesta as $valor){

      $total=$total+$valor;
    }
    return $total;
  }

  /**
   * Funcion que calcula el precio total de la cesta
   */
  function precioTotalCesta($cesta){
    global $productos;
    $precioTotal=0;

    foreach($_SESSION['cesta'] as  $clave =>$valor){


      foreach($productos as $valorProducto){
        if(($clave==$valorProducto['nombre'])){
          
          $precioTotal=$precioTotal+$valorProducto['precio']*$valor;
        }
  }
}
return $precioTotal;
  }

/**
 * Función para eliminar el producto
 * Esto no me da tiempo ha terminarlos ha hacerlos
 */
function modidicarCantidadProducto(&$cesta,$cantidad){

  foreach($cantidad as $clave=>$valor){
    $cesta[$clave]=$valor;
    if($valor==0){
      unset($cesta[$clave]);

    }
  }
  
}


