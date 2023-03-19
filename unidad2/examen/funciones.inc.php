<?php
function conectar($host,$nombreUsuario,$pass,$baseDatos){

    $conexion=mysqli_connect($host,$nombreUsuario,$pass,$baseDatos);

    return $conexion;
}
function mostrarTabla($conexion){
    $consulta='SELECT * FROM city';
    $resultado=$conexion->query($consulta);
    if(!$resultado || $conexion->affected_rows == 0){
        echo '<p>Ha habido un problema con la consulata</p>';
    }
    else{
    echo '<table>';
    echo '<tr>';
    echo '<td>ID</td>';
    echo '<td>Nombre</td>';
    echo '<td>Código ciudad</td>';
    echo '<td>Distrito</td>';
    echo '<td>Ciudad</td>';
    echo '</tr>';
    while($ciudad=$resultado->fetch_array()){
    echo '<tr>';
    echo '<td>'.$ciudad['ID'].'</td>';
    echo '<td>'.$ciudad['nombre'].'</td>';
    echo '<td>'.$ciudad['CountryCode'].'</td>';
    echo '<td>'.$ciudad['District'].'</td>';
    echo '<td>'.$ciudad['Population'].'</td>';
    echo '</tr>';
}
echo '</table>';
}
}
