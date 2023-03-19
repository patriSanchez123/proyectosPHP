<?php 
function conectar($params){
    $conexion = @new mysqli($params['host'], $params['username'], $params['password'], $params['dbname']);
    $error = $conexion->connect_errno;
    if ($error != 0) {
        $mensaje = '<p>Error de conexión a la base de datos. Texto del error: '. $conexion->connect_error.'<br> Vuelve en un ratito colega.</p>';
        echo $mensaje;
        return false;
    }else{

      return $conexion;
    }
}

function aniadirArticulo(){


    $contadorCesta=count($_POST['cesta']);
    $key=array_keys($_POST['cesta']);
    $cantidad=$_POST['cantidadInsertado'];
    
    if($cantidad >1){
      for ($i=0; $i < $cantidad; $i++) { 
        array_push($_SESSION['cesta'],$key[0]);
      }
    }else{
      array_push($_SESSION['cesta'],$key[0]);

    }
}

function eliminarArticulo(){

    $keyEliminar=array();
    $keyEliminar=array_keys($_POST['eliminar']);
    $cantidad=$_POST['cantidadBorrado'];

      foreach($_SESSION['cesta'] as $clave => $valor){

        if($valor==$keyEliminar[0]){
          unset($_SESSION['cesta'][$clave]);
          $cantidad--;
        }
        if($cantidad==0){
          //Sale del bucle si la cantidad de eliminar es cero
          break;
        }
      
    }

}

function calcularPrecioCarrito($conexion){
  $total=0;
  foreach ($_SESSION['cesta'] as $valor){
    
    $consulta='SELECT * FROM producto WHERE cod=\''.$valor.'\'';
    $resultado=$conexion->query($consulta);
    $precio=$resultado->fetch_array();
    $total=$total+$precio['PVP']; 
  }
  return $total;
  
}



/**
 * Función que envia el producto dependiendo del codigo
 */
function mostarObjetos($codObjeto,$conexion){
    $consulta='SELECT * FROM producto WHERE cod=\''.$codObjeto.'\'';
    $resultado=$conexion->query($consulta);
    $producto=$resultado->fetch_array();
   return $producto;

}

/**
 * Función que añade a la varible de sesión los productos
 */
function aniadirProductos($codObjeto,$cantidad){

$_SESSION['productos'][$codObjeto]=$cantidad;
}

/////////////////////////////Modificar la cesta 
function mostrarCesta($conexion){
//Variable para contar el producto
  $total=0;
  echo '<table>';
  echo '<tr>';
      echo '<td>Articulo</td>';
      echo '<td>Precio</td>';
      echo '<td>Unidades</td>';
      echo '<td>Total</td>';
  echo '</tr>';

  foreach ($_SESSION['productos'] as $clave =>$valor){
    //Variables
    $contadorProducto=0;
    $consulta='SELECT * FROM producto WHERE cod=\''.$clave.'\'';
    $resultado=$conexion->query($consulta);
    $producto=$resultado->fetch_array();
    $unidades=intval($valor); 
    $calcularPrecioUnidades=$producto['PVP']*$unidades; 
//Si la cantidad del producto es 0 no imprime nada
    if($valor >0){
      echo '<tr>';
      echo '<td>'.$producto['nombre_corto'].'</td>';
      echo '<td>'.$producto['PVP'].'€</td>';
      echo '<td>'.$valor.'</td>';
      echo '<td>'.$calcularPrecioUnidades.'€</td>';
      echo '</tr>';
      $total=$total+$calcularPrecioUnidades;
      $contadorProducto++; 
    }
  
}
//Si no existe ningun producto no imprira el precio
if($contadorProducto>0){
  echo '<tr>';
  echo '<td COLSPAN="4">Precio Total de la cesta='.$total.'€</td>';
  echo '</tr>';
echo '</table>';
}else{
   echo '<p>No ha añadido a la cesta ningun producto</p>';
}
}
 
  



    
