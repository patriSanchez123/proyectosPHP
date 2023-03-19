<?php
function actualizarUno($conexion){
    //
    /**
     * Para actualizar cogemos la clave de actualizar,
     * Donde indicaremos el nombre queremos actualizar ya que lo tengo como array 
     * y saber el nombre en concreto por el que se quiere cambiar
     */
    $nombre=array();
    $nombre=$_POST['nombreCiudad'];
    $idParaActualizar=$_POST['actualizar'];
    $claveID=array_keys($idParaActualizar);
     
    $consulta='UPDATE city SET nombre=? WHERE ID=?';
    $incluirVariables=$conexion->prepare($consulta);
    $incluirVariables->bind_param('si',$nombre[$claveID[0]],$claveID[0]);
    $incluirVariables->execute();
    

    
}

function actualizarVarios($conexion){

    $nombres=$_POST['nombreCiudad'];
    $consulta='UPDATE city SET nombre=? WHERE ID=?';
    
    foreach($nombres as $clave =>$valor){
 
        $incluirVariables=$conexion->prepare($consulta);
        $incluirVariables->bind_param('si',$valor,$clave);
        $incluirVariables->execute();
        }
       
    }
    function claveprimaria($conexion){
         $consulta=$conexion->query ('SELECT ID FROM city ORDER BY ID DESC LIMIT 1');
         $consultaClave=$consulta->fetch_array();
         $clave=$consultaClave['ID'];
         $IDnueva=intval($clave);
         $IDnueva++;
    
        return $IDnueva;
    }
    
    function insertarCiudadBaseDatos($conexion){
        //ID,Name,CountryCode,District,Population
        $id=claveprimaria($conexion);
        $nombre=$_POST['nombreNuevo'];
        $clavePais=$_POST['pais'];
        $distrito=$_POST['distrito'];
        $poblacion=intval($_POST['poblacion']);
    
    
        $query='INSERT INTO city VALUES (? , ?, ? , ?, ?)';
        $incluirVariables=$conexion->prepare($query);
        $incluirVariables->bind_param("isssi", $id, $nombre, $clavePais, $distrito, $poblacion);
        if(!$incluirVariables->execute()){
            echo '<p>Ha ocurrido un error al insertar en la base de datos</p>';
        }
    }
function borrarCiudad($conexion){
      $clave = array_keys($_POST['borrar']);
      $clave = $clave[0];
      $consulta='DELETE FROM city WHERE ID = \''.$clave.'\'';
      
      if(!$conexion->query($consulta)||($conexion->affected_rows == 0)){
        echo '<p>Ha ocurrido un error al borrar la ciudad</p>';
      }


}
function mostrarTabla($conexion,$consulta){
$resultado=$conexion->query($consulta);
 echo '<tr>';
        echo '<td>ID</td>';
        echo '<td>Nombre</td>';
        echo '<td>Pais</td>';
        echo '<td>Distrito</td>';
        echo '<td>Poblacion</td>';
echo '</tr>';
while($mundo=$resultado->fetch_array()){
 echo '<tr>';
        echo '<td>'. $mundo['ID'].'</td>';
        echo '<td>'. $mundo['nombre'].'</td>';
        echo '<td>'. $mundo['CountryCode'].'</td>';
        echo '<td>'. $mundo['District'].'</td>';
        echo '<td>'. $mundo['Population'].'</td>';
echo '</tr>';
}
}
