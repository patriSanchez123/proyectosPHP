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