<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos- Operacipnes CRUD</title>
</head>
<style>
    .mainContainer{
margin: auto;

    }
    .registrosContainer{
    border-right: solid 1px black;
    display: inline-block;
    margin: 1rem;

        
    }
    .updateContainer{
        margin: 1rem;
        display: inline-block;


    }
</style>
<body>
<?php 
include_once('./funciones.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mesajeError=" ";

@ $conexion = new mysqli('localhost', 'root', '', 'employees');

$error=$conexion->connect_errno;

if($error !=0){

?>
<!--En el caso si hay error en html-->
<p>Error de conexión el la base de datos</p>
<?php
echo $conexion->connect_error;
exit();
}else{
    //1.-Recigida y gestón de datos presentes en post
    //TODO
    if(isset($_POST)&& !empty($_POST)){

        echo '<pre>'.print_r($_POST).'</pre>';

    }if(isset($_POST['delete'])){
        
        //AQUI GESTIONAMOS ELIMINAR
        $clave=array_keys($_POST['delete']);
        $clave=$clave[0];
        $conexion->query("DELETE FROM departments WHERE dept_no = '$clave'");

        if(!$conexion->query("DELETE FROM departments WHERE dept_no = '$clave'") || ($conexion->affected_rows==0)){

            $mensajeError="No se han encontrado registros con esa clave";
        }

    
    }elseif(isset($_POST['addButoon'])){
        //AQUI GESTIONAMOS AÑADIR
        
        
        $clave=claveDepartamentos($conexion);
        

            
        //$conexion->query ("INSERT INTO departments(dep_name,dept_no) VALUES'".($_POST['new_departament_name'])."',".claveDepartamentos($conexion).`'`.'"');
        
        $sql = "INSERT INTO departments (dept_name,dept_no) VALUES ('{$_POST['new_departament_name']}','{$clave}')";

        if (!$conexion->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conexion->error;}
         
        
     }elseif(isset($POST_['updateButoon'])){

        

    }

    //2.- Generación del formulario y impresión
        //Me traigo todos los registros de la tabla departamento 

        $resultado= $conexion->query('SELECT * FROM departments');
        //echo '<pre>'.print_r($resultado).'</pre>';
        //$stock=$resultado->fetch_array();

        // while($departamento=$resultado->fetch_array()){
        //     echo '<pre>'.print_r($departamento).'</pre>';
            
        // }
    
?>

    <div class="mainContainer">
        <h1>Departamentos</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="addContainer">
        <input type="submit" value="+" name="addButoon"><input type="text"  placeholder="Nombre nuevo departamento" name="new_departament_name">
        </div>
        <div class="registrosContainer">
        <?php  while($departamento=$resultado->fetch_array()){?>
        <input type="submit" value="x" name="delete[<?php echo $departamento['dept_no']; ?>]">
        <input type="text" value="<?php echo $departamento['dept_name']; ?>" name="name[<?php echo $departamento['dept_name']; ?>]"><br>
        <?php }?>
        </div>
        <div class="updateContainer">
        <input type="submit" value="Actualizar Registros" name="updateButoon">
        </div>
    
    
    </form>
    </div>
<?php 
$conexion->close();
} ?>

    
    
</body>
</html>