<?php
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
    $nombre=$_POST['nombreCiudad'];
    $clavePais=$_POST['pais'];
    $distrito=$_POST['distrito'];
    $poblacion=intval($_POST['poblacion']);


    $query='INSERT INTO city VALUES (? , ?, ? , ?, ?)';
    $incluirVariables=$conexion->prepare($query);
    $incluirVariables->bind_param("isssi", $id, $nombre, $clavePais, $distrito, $poblacion);
    $incluirVariables->execute();
}

function actualizar($conexion){
    $ciudades=array();
    $ciudades=$_POST['nombre'];
    $nom='Name';


    foreach($ciudades as $clave => $valor){

        //incorporar más adelante
        $id=intval($clave);
        $consulta= 'UPDATE city  SET nombre=? WHERE ID=?';
        $incluirVariables=$conexion->prepare($consulta);
    $incluirVariables->bind_param("si", $valor, $id);
    $incluirVariables->execute();
}


    }
