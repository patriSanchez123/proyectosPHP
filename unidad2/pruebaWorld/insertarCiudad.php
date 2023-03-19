<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Ciudad</title>
        
</head>
<body>
<?php
    require_once('./config.inc.php'); 
    require_once('./funciones.inc.php'); 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $consultaGuardada=array();
    $conexion=new mysqli($conexionBaseDatos['host'],$conexionBaseDatos['usuario'],
                        $conexionBaseDatos['password'],$conexionBaseDatos['base de datos']);
    //Variable para que nos muestre el error                    
    $error=$conexion->connect_errno;

    if($error!=0){

        echo '<p>No se ha podido conectar a la base de datos</p>';
        exit();
    }else{?>
       

    <?php
    /**
     * Muestra tabla con la consulta serializada antigua
     */
        if(isset($_POST['datosAntiguos'])){ ?>
        <table>        
        <?php 
            $consultaGuardada=unserialize(base64_decode($_POST['datosAntiguos']));
            mostrarTabla($conexion,$consultaGuardada);
        ?>
        </table>
        
</table>
            
   <?php /**
     * Muestra tabla con la conslta serializada Nueva
     */
}elseif(isset($_POST['consultaSerializada'])){?>
        <table>
            <?php $consultaGuardada=unserialize(base64_decode($_POST['consultaSerializada']));?>
            <?php mostrarTabla($conexion,$consultaGuardada);?>
        </table>
        <?php
        /**
         * Comprueba que existan todos los datos para poder insertar
         */
        }if(isset($_POST['insertarDatos']) && (isset($_POST['nombreNuevo']) && !empty($_POST['nombreNuevo']))&& (isset($_POST['pais']) && !empty($_POST['pais']))
        && (isset($_POST['distrito']) && !empty($_POST['distrito']))&&(isset($_POST['poblacion']) && !empty($_POST['poblacion']))){
        
        insertarCiudadBaseDatos($conexion); 
        }else{
            echo 'Error hay algun dato que no está relleno.Revise todos los datos';
        
        
        }if(isset($_POST['actualizarDatos'])){
            echo '<p>Datos actualizados</p>';
        }?>    
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <label for="nombreNuevo">Nombre<input type="text" name="nombreNuevo" id="nombreNuevo"></label>
    <label for="pais">Pais
    <select name="pais" id="pais">
    <?php 
        $consulta='SELECT * FROM country';
        $resultado=$conexion->query($consulta);
        while($pais=$resultado->fetch_array()){ 
    ?>    
            <option value="<?php echo $pais['Code'] ?>"><?php echo $pais['Name']?></option>
            <?php }?>
        </select>
    </label>
    <label for="distrito">Distrito<input type="text" name="distrito" id="distrito"></label>
    <label for="poblacion">Población<input type="number" name="poblacion" id="poblacion"></label>
    <input type="submit" value="Insertar datos" name="insertarDatos">
    <input type="submit" value="Actulizar datos" name="actualizarDatos">
    <input id="prodId" name="consultaSerializada" type="hidden" value="<?php echo base64_encode(serialize($consultaGuardada)); ?>">
</form> 
<form action="./pruebaWorld.php" method="post">
    <input type="submit" name="volverPantallaIncio">
</form>
        
        <?php 
        }?>
</body>
</html>