<?php
function conectar($params)
{
  $conexion = @new mysqli($params['host'], $params['username'], $params['password'], $params['dbname']);
  $error = $conexion->connect_errno;
  if ($error != 0) {
    $mensaje = '<p>Error de conexión a la base de datos. Texto del error: ' . $conexion->connect_error . '<br> Vuelve en un ratito colega.</p>';
    echo $mensaje;
    return false;
  } else {
    return $conexion;
  }
}
/**
 * Función que añade producto a la cesta mediante el cod del producto
 * si es mas de un producto añade varios con un for
 */
function aniadirArticulo()
{

  $key = array_keys($_POST['cesta']);
  $cantidad = $_POST['cantidadInsertado'];

  if ($cantidad > 1) {
    for ($i = 0; $i < $cantidad; $i++) {
      array_push($_SESSION['cesta'], $key[0]);
    }
  } else {
    array_push($_SESSION['cesta'], $key[0]);
  }
}

/**Función que elimania producto mediante el cod del producto  */
function eliminarArticulo()
{
  //cogemos la clave del producto para eliminar de la cesta si si es más de un producto 
  //el contador cantidad decrementa hasta que salga del bucle con un break
  $keyEliminar = array();
  $keyEliminar = array_keys($_POST['eliminar']);
  $cantidad = $_POST['cantidadBorrado'];

  foreach ($_SESSION['cesta'] as $clave => $valor) {

    if ($valor == $keyEliminar[0]) {
      unset($_SESSION['cesta'][$clave]);
      $cantidad--;
    }
    if ($cantidad == 0) {
      //Sale del bucle si la cantidad de eliminar es cero
      break;
    }
  }
}
/**
 * Función que calcula el precio del carrito 
 */
function calcularPrecioCarrito($conexion)
{
  $total = 0;
  foreach ($_SESSION['cesta'] as $valor) {

    $consulta = 'SELECT * FROM producto WHERE cod=\'' . $valor . '\'';
    $resultado = $conexion->query($consulta);
    $precio = $resultado->fetch_array();
    $total = $total + $precio['PVP'];
  }
  return $total;
}
