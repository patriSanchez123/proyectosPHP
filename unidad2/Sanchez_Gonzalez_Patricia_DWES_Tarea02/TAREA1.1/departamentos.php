<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Departamentos - operaciones CRUD</title>
    <style>
      .mainContainer{
        margin:auto;
      }
      .registrosContainer{
        border-right: solid 1px black;
        display: inline-block;
        margin: 1rem;
        padding: 0.5rem;
      }
      .updateContainer{
        margin: 1rem;
        display:inline-block;
      }
      .error_message{
        color: red;
      }
    </style>
  </head>
   
<body>

<?php

require_once ('mysql_funciones.inc.php');
require_once('./config.inc.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



 $conexion = new mysqli($conexionBaseDatos['dominio'],$conexionBaseDatos['usuario'],$conexionBaseDatos['password'],$conexionBaseDatos['base de datos']);

$error = $conexion->connect_errno;

if ($error != 0) {
?>
  <!-- Este es el HTML si hay error -->
  <p>Error de conexión a la base de datos. Texto del error: <?php echo $conexion->connect_error; ?>  Vuelve en un ratito colega.</p>;
<?php 
     exit();
}else{
  //Este código se ejecuta si la conexión a la base de datos ha ido bien.
  //0.- Inicialización de variables
  $mensaje_error_cliente = '';
  
  //1.- Recogida y gestión de datos presentes en _POST
  if(isset($_POST)&&!empty($_POST)){
  echo '<pre>'.print_r($_POST).'</pre>';
    if(isset($_POST['delete'])){
      //Aquí gestionamos el eliminar
      $clave = array_keys($_POST['delete']); //Array_keys obtiene un array cuyos valores son las claves del array pasado como parámetro (y sus claves son índices 0, 1, 2...)
      $clave = $clave[0];
      
      if(!$conexion->query('DELETE FROM departments WHERE dept_no = \''.$clave.'\'')||($conexion->affected_rows == 0)){
        $mensaje_error_cliente = 'Se ha jodio el asunto colega';
      }
    }else if(isset($_POST['add_button'])){
      //Aquí gestionamos añadir
      //echo '<pre>'.print_r($_POST).'</pre>';
      
      $id = getPrimaryKey($conexion);
      
      if(!$conexion->query('INSERT INTO departments (dept_no, dept_name) VALUES (\''.$id.'\', \''.$_POST['new_department_name'].'\')')){
        $mensaje_error_cliente = 'Houston tenemos un problema, el mensaje de error es:'.$conexion->error;
      }else{
        $mensaje_error_cliente = 'Todo bien';
      }
      
    }else if(isset($_POST['update_button'])){
      //Aquí gestionamos el actualizar

      //Inicializamos las variables y le damos valor
      $departamentos=array();
      $departamentos=$_POST['name'];

      foreach($departamentos as $clave =>$departamento){

          //Donde aparecen las interrogaciones son variables que se van a 
          //incorporar más adelante
          $consulta= 'UPDATE departments  SET dept_name= ? WHERE dept_no= ?';
          //Se prepara la consulta para poder incluir las variables
          $incluirVariables=$conexion->prepare($consulta);
          //Se insertan las variables, las eses van dependiendo de las variables que se inserten
          $incluirVariables->bind_param("ss",$departamento,$clave);
          //Ejecutamos los parametros a las sentencias anteriores
          $incluirVariables->execute();

        
    }
    
  }
  }
  
  //2.- Generación e impresión del formuilario
    //Me traigo todos los registros de la tabla departamento
    
    $resultado = $conexion->query('SELECT * FROM departments ORDER BY dept_no ASC');
     
?>
  <div class="mainCointainer"> 
    <h1>Departamentos</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
       <div class="addContainer">
         <input type="submit" value="+" name="add_button"> <input type="text" value="" placeholder="Nombre nuevo departamento" name="new_department_name"> 
       </div>
       <div class="registrosContainer">
         <?php while($departamento = $resultado->fetch_array()){?> 
           <input type="submit" value="x" name="delete[<?php echo $departamento['dept_no']; ?>]"> <input type="text" value="<?php echo $departamento['dept_name']; ?>" name="name[<?php echo $departamento['dept_no']; ?>]"> <br>
         
         <?php } ?>
         
         
       </div>
       <div class="updateContainer">
         <input type="submit" value="Actualizar registros" name="update_button">
       </div>
    </form>
  </div>
  <div class="error_message"><p>
    <?php echo $mensaje_error_cliente; ?>
  </p></div>
  <?php 
    $conexion->close();
  }?>
</body>
</html>