<?php 
$totalPasos=4;
function conectar($parametros){

$conexion= @new mysqli($parametros['host'],$parametros['nombre'],
$parametros['contrasenia'],$parametros['baseDeDatos']);
$errorConexion=$conexion->connect_errno;

if($errorConexion!=0){
echo '<strong>No se ha podido conectar con la base de datos</strong>';
  exit();
    return false;
}else{
    return $conexion;
  }
}

/**
 * Función que comprueba el usuario y la contrasseña
 */
function comprobarUsuarioContrasenia($conexion){

  $consulta='SELECT * FROM usuarios WHERE usuario=\''.$_POST['nombreUsuario'].'\' AND contrasena=\''.$_POST['contraseniaUsuario'].'\'';
  $resultados=$conexion->query($consulta);
  

  if(!$resultados){
    echo '<strong>La consulta en la base de datos no es correcta</strong>';
  }else{

    $contadorColumnas=$resultados->num_rows;

  if($contadorColumnas >0){

      return true;

  }else{
      return false;
  }
}
}

function insersionProductosSesion($parametros,$LimiteRows,$desdeConsulta,&$productos){

  $conexion=conectar($parametros);
  if($conexion){
    $contador=0;
    $consulta='SELECT * FROM producto LIMIT '.$LimiteRows.' OFFSET '.$desdeConsulta;
    $resultado=$conexion->query($consulta)->fetch_all();

    foreach($resultado as $producto){
      $productos[$contador]=array(
            'infoProducto'=>array(
                                  'cod'=>$producto[0],
                                  'nombre'=>$producto[2],
                                  'precio'=>$producto[4],
                                  'cantidad'=>0)
      );
      $contador++;
    }
      
  }  
  return $productos;
}

function imprimirFormulario($formulario){

     
      $nuevoFormulario="";
      if($formulario['pasoActual']>=0 && $formulario['pasoActual']<=3){
      
     echo '<h2>'.$formulario['producto'][$formulario['pasoActual']]['infoProducto']['nombre'].'</h2><br>';
     echo'<p>Precio: '. $formulario['producto'][$formulario['pasoActual']]['infoProducto']['precio'].'€</p>';

      }
      $nuevoFormulario.='<form method="post" action="./formulario.php">';
      if($formulario['pasoActual']>=0 && $formulario['pasoActual']<=3){

        $nuevoFormulario.='<label for="cantidad">Cantidad de producto<input type="number" id="cantidad" name="cantidad"></input></label><br>';
      }
      
    if($formulario['pasoActual']>0){
      
      $nuevoFormulario.='<input type="submit" name="atras" value="Atras"></input>';
  }
  if($formulario['pasoActual']<3){

    $nuevoFormulario.='<input type="submit" name="siguiente" value="siguiente"></input>';
  }
  if($formulario['pasoActual']==3){
    $nuevoFormulario.='<input type="submit" name="comprar" value="Comprar"></input>';

  }
  $nuevoFormulario.='</form>';
    return $nuevoFormulario;
}

function aniadirCantidad(&$formulario,$cantidad){

  $formulario['producto'][$formulario['pasoActual']]['infoProducto']['cantidad']=$cantidad;
}

/**
 * Función donde calcula el precio total de las unidades en un bucle
 * donde recorra el formulario
 */
function calcularTotalUnidades($formulario,$indiceProducto){
  
$total=0;

    $precioUnidad=$formulario['producto'][$indiceProducto]['infoProducto']['precio'];
    $cantidad=floatval($formulario['producto'][$indiceProducto]['infoProducto']['cantidad']);
    $total=$precioUnidad*$cantidad;
    return $total;

}

function mostrarCesta($formulario){
  $totalCesta=0;
  $formularioLength=count($formulario['producto']);
  echo $formularioLength;
  $tabla='<table>';
  $tabla.='<tr>';
  $tabla.='<td>Nombre</td>';
  $tabla.='<td>Precio</td>';
  $tabla.='<td>Unidades</td>';
  $tabla.='<td>Precio total Unidades</td>';
  $tabla.='</tr>';

for ($i=0; $i < $formularioLength; $i++) { 
  //$contadorProductos=0;
  if($formulario['producto'][$i]['infoProducto']['cantidad']>0){
  $tabla.='<tr>';
  $tabla.='<td>'.$formulario['producto'][$i]['infoProducto']['nombre'].'</td>';
  $tabla.='<td>'.$formulario['producto'][$i]['infoProducto']['precio'].'</td>';
  $tabla.='<td>'.$formulario['producto'][$i]['infoProducto']['cantidad'].'</td>';
  $tabla.='<td>'.calcularTotalUnidades($formulario,$i).'</td>';
  $tabla.='</tr>';

  }
  
  $totalCesta=$totalCesta+calcularTotalUnidades($formulario,$i);
}
  $tabla.='<tr>';
  $tabla.='<td COLSPAN="4">Precio total: '.$totalCesta.'</td>';
  $tabla.='</tr>';
  $tabla.='</table>';

  print_r($formulario['producto']); 

return $tabla;

}








    
