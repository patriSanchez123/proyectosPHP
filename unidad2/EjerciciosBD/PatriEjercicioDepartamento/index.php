<?php 

@ $conexion = new mysqli('localhost', 'root', '', 'employees');
//print $conexion->server_info;
$resultado = $conexion->query('SELECT dept_name, dept_no FROM departments');


while($department = $resultado->fetch_array()){

    print_r($department);
    echo '<br>';    
}

$conexion->close();
?>
