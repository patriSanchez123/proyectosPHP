<?php 
function conectar($host,$usuario,$contrasena,$bbdd){

    $conexion= @new mysqli($host,$usuario,$contrasena,$bbdd);
    $error=$conexion->connect_errno;
    if($error!=0){
        echo '<p><strong>No se ha podido conectar con la base de datos</strong></p>';
    }else{
        return $conexion;
    }
}

function comprobarLogin($conexion,$usuario,$contrasena){
    $loginCorrecto=false;
    $consulta='SELECT * FROM usuarios WHERE usuario=\''.$usuario.'\' AND contrasena=\''.$contrasena.'\'';
    $resultado=$conexion->query($consulta);
    if($resultado==false){
        echo '<p><strong>Ha ocurrido un problema al realizar la consulta con la base de datos</strong></p>';
    }else if($resultado->num_rows >0){
        $loginCorrecto=true; 
    }
    return $loginCorrecto;
}

function inicializarCesta($conexion,&$cesta){

    $consulta=$consulta='SELECT * FROM producto';
    $productos=$conexion->query($consulta)->fetch_all();

    if($productos==false){
        echo '<p><strong>Ha ocurrido un problema al realizar la consulta con la base de datos</strong></p>';
    }else{
        foreach($productos as $producto){
        $cesta+=array($producto[0]=>0);
        
    }
    }

}
function consultaProductosPorPagina($conexion,$productosPorPágina,$paginaActual){
//Consulta para saber cuantos productos hay
    $productos=array();
    $productosTotales=$conexion->query('SELECT * FROM producto')->num_rows;
//total paginas
    $totalPaginas=intval($productosTotales/$productosPorPágina);
    $paginaParaMostar= (($paginaActual-1)*$productosPorPágina);
//Si para mostrar los productos las paǵinas tiene un resto no es cero en la ultima pagina se imprime uno más 
///////////////////////////////////////////////////////////////////////////////////////
 if($productosTotales%$productosPorPágina!=0 && $paginaActual==$totalPaginas+1){
    $restoProductos=$productosTotales%$productosPorPágina;
    $consulta='SELECT * FROM producto ORDER BY cod ASC LIMIT '.$paginaParaMostar.','.$restoProductos;
    $productos=$conexion->query($consulta)->fetch_all();
 }else{
        $consulta='SELECT * FROM producto ORDER BY cod ASC LIMIT '.$paginaParaMostar.','.$productosPorPágina;
        $productos=$conexion->query($consulta)->fetch_all();   
    }

    if($productos==false){
        echo '<p><strong>Ha ocurrido un problema al realizar la consulta con la base de datos</strong></p>';
    }else{
        return $productos;
    }

}

function formularioProductos($conexion,$productosPorPágina,$paginaActual,$cesta){
   $productosPagina=consultaProductosPorPagina($conexion,$productosPorPágina,$paginaActual);
   $productosTotales=$conexion->query('SELECT * FROM producto')->num_rows;
   $totalPaginas=intval($productosTotales/$productosPorPágina);
   if($productosTotales%$productosPorPágina!=0){
    $totalPaginas++;
   }

   $form='';
   $form.='<table>';
   $form.='<tr>';
   $form.='<td>Nombre</td>';
   $form.='<td>Descrpcion</td>';
   $form.='<td>Precio</td>';
   $form.='</tr>';
   $form.='<form action="./productos.php" method="post">';
   foreach($productosPagina as $producto){
   $form.='<tr>';
   $form.='<td>'.$producto[2].'</td>';
   $form.='<td>'.$producto[3].'</td>';
   $form.='<td>'.$producto[4].'</td>';
   $form.='<td><input type="number" name=cantidad['.$producto[0].'] value='.$cesta[$producto[0]].'><input type="image" src="./fotos/shopping-cart-add-button_icon-icons.com_56132.png" name=agregarCesta['.$producto[0].']></input></td>';
   $form.='</tr>';
   }
   $form.='</table>';
   if($paginaActual!=1){

    $form.='<input type="submit" name="atras" value="Atras">';
   }
   //Tengo que preparar el contador de paginas por si hace falta agregar una más para todos los productos
   if($paginaActual==$totalPaginas){
    $form.='<input type="submit" name="comprar" value="Comprar">';
   }else{
    $form.='<input type="submit" name="siguiente" value="siguiente">';
   }
   $form.='</form>';
   echo $form; 
}

function aniadirACarrito($agregarCesta,$cantidad,&$cesta){
    $codProducto=array();
    $codProducto=array_keys($agregarCesta);
    $cesta[$codProducto[0]]=$cantidad[$codProducto[0]];
    

}

function insertarTodaPagina($cantidad,&$cesta){
    foreach($cantidad as $clave => $valor){
        $cesta[$clave]=$valor;

    }
   
}
/**
 * Modifica la cesta dependiendo del código del botón eliminar 
 * y inserta el digito del numero introducido con el código de la cesta 
 */
function borraArticulo($eliminar,$cantidad,&$cesta){
    $codProducto=array();
    $codProducto=array_keys($eliminar);
    $cesta[$codProducto[0]]=$cesta[$codProducto[0]]-$cantidad[$codProducto[0]];

}

function imprimirCesta($conexion,$cesta){
    $total=0;
    $form="";
    $form.='<form action="./comprar.php" method="post">';
    $form.='<table>';
    $form.='<tr>';
    $form.='<td>Nombre</td>';
    $form.='<td>Precio</td>';
    $form.='<td>Unidades</td>';
    $form.='<td>TotalUnidades</td>';
    $form.='<td></td>';
    $form.='</tr>';
    
    foreach($cesta as $clave=> $valor){
        $consulta='SELECT * FROM producto WHERE cod=\''.$clave.'\'';
        $producto=$conexion->query($consulta)->fetch_array();
        if($valor>0){
        $form.='<tr>';
        $form.='<td>'.$producto['nombre_corto'].'</td>';
        $form.='<td>'.$producto['PVP'].'€</td>';
        $form.='<td>'.$valor.'</td>';
        $form.='<td>'.$producto['PVP']*$valor.'€</td>';
        $form.='<td><input type="number" name=cantidad['.$producto['cod'].'] min="1" max="'.$valor.'"><input type="submit" name=eliminar['.$producto['cod'].'] value="Eliminar"></td>';
        $form.='</tr>';
        $total=$total+($producto['PVP']*$valor);
    }
}   
    $form.='<tr><td colspan=5 >Total '.$total.'€</td></tr>';
    $form.='</table>';
    $form.='<input type="submit" name="atras"value="Atras">';
    $form.='</form>';
    echo $form;
}