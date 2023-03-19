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

function paso1($codObjeto,$conexion){

  for ($i=0; $i < 6; $i++) { 
    # code...
  }
  mostarObjetos($codObjeto,$conexion);

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
 
function paso_1($conexion){?>
  <div id="paso1">
        <?php $keys=array_keys($_SESSION['productos']);?>
        <p>Inserte la cantidad que desea de este articulo</p>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        for ($i=0; $i < 6; $i++) { 
            $resultado=mostarObjetos($keys[$i],$conexion); ?>
        <label for="<?php echo $keys[$i]?>"><?php echo $resultado['nombre_corto']?>  <input type="number" id="<?php echo $keys[$i]?>" name="cantidad[<?php echo $keys[$i]?>]"></label><br>
        <?php }?>
        <input type="submit" name="paso2" value="Siguiente">
        </form>
    </div>

<?php }?> 

<?php 
function paso_2($conexion){?>
  <div id="paso2">
        <?php 
        $keys=array_keys($_SESSION['productos']);
        
        foreach($_POST['cantidad'] as $clave =>$valor){ 
            aniadirProductos($clave,$valor);   
        }

        //////Esto tengo que mofificarlo bien con lo de arriba y ponerle un for 
        print_r($_SESSION['productos']);?>
        <p>Inserte la cantidad que desea de este articulo</p>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        for ($i=5; $i < 12; $i++) { 
            $resultado=mostarObjetos($keys[$i],$conexion); ?>
        <label for="<?php echo $keys[$i]?>"><?php echo $resultado['nombre_corto']?>  <input type="number" id="<?php echo $keys[$i]?>" name="cantidad[<?php echo $keys[$i]?>]"></label><br>
        <?php }?>
        <input type="submit" name="paso1" value="Atras">
        <input type="submit" name="paso3" value="Siguiente">
        </form>
    </div>

<?php }?>

<?php

function paso_3($conexion){


}



    
