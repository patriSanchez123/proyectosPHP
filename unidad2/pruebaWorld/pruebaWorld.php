<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo.css">
    <title>World</title>
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('./config.inc.php');
require_once('./funciones.inc.php');

$resultado2=array();
//Conectamos base de datos
    $conexion=new mysqli($conexionBaseDatos['host'],$conexionBaseDatos['usuario'],
                        $conexionBaseDatos['password'],$conexionBaseDatos['base de datos']);
    //Variable para que nos muestre el error                    
    $error=$conexion->connect_errno;

    if($error!=0){

        echo '<p>No se ha podido conectar a la base de datos</p>';
        exit();
    }else{
    
        if(isset($_POST['actualizar'])){
            actualizarUno($conexion);
          
        }
        elseif(isset($_POST['actulizarVarios'])){

            actualizarVarios($conexion);
        }elseif(isset($_POST['borrar'])){
            borrarCiudad($conexion);
        }

        
    ?>
    

   <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <?php
    $consulta='SELECT * FROM city ORDER BY ID DESC LIMIT 30';
    $resultado=$conexion->query($consulta);
    $consulta2='SELECT * FROM city ORDER BY ID DESC LIMIT 30';?>
    

    <table>
        <tr>
            <td>ID</td>
            <td>Nombre</td>
            <td>Pais</td>
            <td>Distrito</td>
            <td>Poblacion</td>
        </tr>
        <?php while($mundo=$resultado->fetch_array()){?>
            <tr>
                <td><?php echo $mundo['ID'] ?></td>
                <td><label for="nombre"><input type="text" value="<?php echo $mundo['nombre']?>" id="nombre" name="nombreCiudad[<?php echo $mundo['ID']?>]"></label></td>
                <td><?php echo $mundo['CountryCode'] ?></td>
                <td><?php echo $mundo['District'] ?></td>
                <td><?php echo $mundo['Population'] ?></td>
                <td class="sub"><input type="submit" name='borrar[<?php echo $mundo['ID']?>]' value="X"></td>
                <td class="sub"><input type="submit" name='actualizar[<?php echo $mundo['ID']?>]' value="Modificar"></td>
            </tr>
        
    
    <?php 
//
}?>
</table>
<input type="submit" name='actulizarVarios' value="Actualizar Varios">

<?php } ?>

</form> 
<form action="./insertarCiudad.php" method="POST">
<input type="submit" name='insertar' value="Insertar Ciudad">
<input id="prodId" name="datosAntiguos" type="hidden" value="<?php echo base64_encode(serialize($consulta2)); ?>">
</form>
</body>
</html>