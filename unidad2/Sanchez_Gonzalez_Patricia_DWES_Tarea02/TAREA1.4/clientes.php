<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Clientes</title>
    <link rel="stylesheet" href="./css/stylo.css">
</head>
<body>
   <?php 

//Documentos para la configuración de la base de datos y funciones
   require_once("./config.inc.php");
   require_once("./funciones.inc.php");

//Errores php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
  
//Variable donde guardaremos el id para las modificaciones
   $idClienteGuardado=array();

//Conectamos a la base de datos
   $conexion= new mysqli($conexionBaseDatos['host'],$conexionBaseDatos['usuario'],
                        $conexionBaseDatos['password'],$conexionBaseDatos['base de datos']);

//Variable para el manejo de los errores al conectarnos a la base de datos                        
    $error= $conexion->connect_errno;
    
//Si $error es diferente a cero,error al conectar a la base de datos
    if($error !=0){
       echo '<span>Ha ocurrido un error al conectar con la base de datos.Texto Error:'.$error.'</span>';
        exit();
    }else{

        if(isset($_GET['fotoCliente'])){
            
        //Función que muestra los datos del cliente
            mostrarCliente($conexion,$idClienteGuardado);
                  
   }else if(isset($_POST['eliminar']) ){
    
        //Función para eliminar foto
            eliminarFoto($conexion);
           
    }else if(isset($_POST['subirArchivo'])){

        cambiarFotoCliente($conexion);
    }
    ?>

    <!--Estas dos condiciones imprimen los formularios dependiendo si no existe la 
    $_GET['fotoCliente'] o no existe--->
   <?php if(!isset($_GET['fotoCliente'])){
        //Imprime la lista de clientes

        /**
         * Creamos una consulta y le pasamos el parametro a la query, recorremos
         * la consulta y le damos valor al input.Introducimos el id de la foto en el
         * indice de un array(hubiera sido más optimo si lo hubiera insertado en el value)
         */
        $query='SELECT * FROM infoClientes';
        $resultado=$conexion->query($query); ?>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
            <div class="datosCliente">
                <?php while($cliente= $resultado->fetch_array()){ ?>

                <h2><?php echo $cliente['nombre']?></h2>
                <input type="image" name="fotoCliente[<?php echo $cliente['ID']?>]" src="<?php echo $cliente['foto']?>"
                alt="Foto cliente">
                 <?php }?>    
    
            </div>
    
     </form>
    <?php }else{ ?>
        <!--Muestra el formulario de modificar cliente cuando el cliente está selecionado
            insertamos el valor del id en el indice del array subirArchivo[] y modificar-->
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post">
        <div class="edicion">
            
            <input name="archivo" id="archivo" type="file"/>
            <input type="submit" value="Modificar" name="subirArchivo[<?php echo $idClienteGuardado?>]">
            <input type="submit" name="eliminar[<?php echo $idClienteGuardado?>]" value="Eliminar">
        </div>
    </form>
    

        <?php }?>
    



<?php 
$conexion->close();

}?>
</body>
</html>

