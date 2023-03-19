<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World</title>
</head>
<body>
<?php
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    $conexion= new mysqli("localhost","root","","world");
    if($conexion->connect_errno){

        echo "Error al conectar la base de datos";
    }else{?>
    <p>Conecta perfe</p>

    <?php

    if(isset($_POST['borrar'])){

        $id=$_POST['borrar'];
        $keyId=array_keys($id);
        $keyBorrar=$keyId[0];
        $query='DELETE FROM city WHERE ID=\''.$keyBorrar.'\'';
        $conexion->query($query);
    }elseif(isset($_POST['crearCiudad'])){ 
        insertarCiudadBaseDatos($conexion);
    }elseif(isset($_POST['actualizar'])){
        actualizar($conexion);

    }
        ?>
                                        <!--FORMULARIOS-->
    <!--FORMULARIO AGREGAR CIUDAD-->                                    
    <?php if(isset($_POST['agregar'])){?>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <label for="nombreCiudad">Nombre de la ciudad<input type="text" name="nombreCiudad" id="nombreCiudad"></label><br>
    <label for="pais">Pais<select name="pais">
    <?php 
    $query='SELECT * FROM country ORDER BY name ASC';
    $resultado=$conexion->query($query);
        while($world=$resultado->fetch_array()){?>
        <option value="<?php echo $world['Code']?>"><?php echo $world['Name']?></option>
    <?php }?>
    </select></label><br>      
    <label for="distrito">Distrito<input type="text" name="distrito" id="distrito"></label><br>
    <label for="poblacion">Población<input type="number" name="poblacion" id="poblacion" min='1000'></label>
    <input type="submit" name="crearCiudad" value="Introducir Datos"><br>
</form>
<!--FORMULARIO MOSTAR CIUDADES-->    
<?php }elseif(!isset($_POST['agregar'])){ ?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   <input type="submit" name="agregar" value="Agregar ciudad"><br>     
        <?php 
        $world=array();
        $query='SELECT * FROM city ORDER BY ID DESC LIMIT 50;';
        $resultado=$conexion->query($query);

        while($world=$resultado->fetch_array()){
        ?>
    <input type="submit" name="borrar[<?php echo $world['ID'] ?>]" value="x">
    <input type="text" name="nombre[<?php echo $world['ID']?>]" value="<?php echo $world['nombre'];?>"><br>
    <?php }?>
    
   <input type="submit" value=Actualizar name="actualizar">
</form>

    
    <?php
    }
    $conexion->close();
    }
?>

    
</body>
</html>