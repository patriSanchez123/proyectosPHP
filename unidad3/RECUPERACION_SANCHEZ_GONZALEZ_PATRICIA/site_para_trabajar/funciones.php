<?php

/** La siguiente función debe generar el código HTML de la cesta, y su formulario asociado
 * Ten presente los ámbitos de las variables y los modificadores que puedes utilizar para cambiarlo
 */
function getBasketMarkup(){
  global $productos;
  //inicializo laa variable para contar el precio total se los productos
  //Ejemplo del HTML generado: ( no tiene por qué coincidir exactamente con el presente en la plantilla HTML )
  //Hay que incluir form
  $basket_markup = '';
  //creamos formulario
  $basket_markup .='<form action="./index.php" method="post">';


  $basket_markup.='<p><strong>Número de items:</strong>'.contarProductosCesta().'</p>
      <p><strong>Precio total:</strong> $'.precioTotal().'</p>
      <hr>';
//recorremos la session cesta para poder imprimir los productos que tenemos en ella siempre que el valor
//sea mayor a cero, insertamos los valores de la cesta y las variables de la cesta sirven para poder imprimir los productos
      foreach($_SESSION['cesta'] as $clave=>$valor){
  $basket_markup.='<div class="cItemContainer">';
        if($valor>0){
  /**
   * Rearobecho incluir cesta ya que hace exactemente lo mismo que incluir del otro formulario
   * de esta manera me ahorro construir otro post
   */
  $basket_markup.='<div class="cFoto"><img src="'.$productos[$clave]['img_miniatura'].'"></div>
        <div class="cNombreProducto"><h3>'.$productos[$clave]['nombre'].'</h3></div>
        <input type="submit" value="-" name="restarArticulos['.$clave.']"> '.$valor.' <input type="submit" value="+" name="incluirCesta['.$clave.']">
        <strong>Precio:</strong>'.$productos[$clave]['precio']*$valor.'€
      </div>';
    }
    
  }
    return $basket_markup;
  }

/** La siguiente función debe generar el código HTML de los productos, con sus botones de 'add to cart' cesta
 * Ten presente los ámbitos de las variables y los modificadores que puedes utilizar para cambiarlo
 */
  function getProductosMarkup(){
    global $productos;
   //Ejemplo del HTML generado: ( no tiene por qué coincidir exactamente con el presente en la plantilla HTML )
   //Hay que incluir form
   $productos_markup = '';
    /**<!-- Producto--> */ 
    //creamos formulario, donde se recorre los productos de la cesta para poder imprimirlos por pantalla
    //con los datos correespondientes
    $productos_markup.='<form action="./index.php" method="post">';
    foreach ($productos as $clave => $valor){
      $productos_markup.='
      <div class="cProductoContainer"><img src="'.$valor['img_url'].'" alt="" width="270" height="280">
        <input type="submit" value="Incluir en cesta" name="incluirCesta['.$clave.']">
        <h4>'.$valor['nombre'].'</h4>
        <p><strong>$'.$valor['precio'].'</strong></p>
      </div>';
      
    }
    $productos_markup.='</form>';
    return $productos_markup;
  }

//Inicializamos los productos de la cesta con la clave de los productos y el valor
//Haciendo un array clave valor, la cesta se ha referenciado para poder modificarla
function iniCesta(&$cesta){
  global $productos;
  //se recorre los productos y se insertan las claves en el array
  foreach($productos as $clave => $valor){
    $cesta+=array($clave=>0);

  }
}

//función donde se añaden los productos a la sesion de cesta 
//lo que hace es sumar uno a la cantidad
  function incluir(&$cesta,$incluir){
   // sacamos la key del post para poder utilizarla en sumarle al producto de la cesta
  $keys= array();
  $keys=array_keys($incluir);

  $cesta[$keys[0]]=$cesta[$keys[0]]+1;

  }

/**
 * Función que calcula el precio total de los productos
 */
function precioTotal(){
  global $productos;
  $precioTotal=0;
//Recorremos la cesta donde multiplicamos la cantidad de la cesta con el precio
// de los productos y lo vamos sumando al preciototal
  foreach($_SESSION['cesta'] as $clave=> $valor){
    $precioTotal=$precioTotal+($productos[$clave]['precio']*$valor);

  }
  return $precioTotal;
  
}

/**
 * Función que quita articulos de la cesta
 */
function restarArticulos(&$cesta,$restar){
  // sacamos la key del post para poder utilizarla en restaselo al producto de la cesta
  $keys= array();
  $keys=array_keys($restar);

  $cesta[$keys[0]]=$cesta[$keys[0]]-1;

}

/**
 * Función que cuenta el total de productos que tenemos en la cesta
 */
function contarProductosCesta(){
  //inicializamos la variable
  $cantidadProductos=0;
  //recorremos la cesta donde vamos sumando el valor de la misma, ya que son la
  //cantidad de los productos
  foreach($_SESSION['cesta'] as $valor){

    $cantidadProductos=$cantidadProductos+$valor;
  }
  return $cantidadProductos;
}

  