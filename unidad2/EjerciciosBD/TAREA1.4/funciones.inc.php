<?php
/**
 * Función que muestra el cliente seleccionado por el usuario
 */
function mostrarCliente($conexion,&$idClienteGuardado){
//Inicializamos variables y le damos valor    
$idCliente=array();
            $idCliente=array_keys($_GET['fotoCliente']);
            $idClienteGuardado=$idCliente[0];
//Realizamos una consulta y la recorremos para dar valor a la foto y al titulo            
    $query='SELECT * FROM infoClientes WHERE ID= \''.$idCliente[0].'\'';
    $resultado=$conexion->query($query);
    echo '<div class="cliente">';
    while($cliente= $resultado->fetch_array()){ ?>
            
                <h2><?php echo $cliente['nombre']?></h2>
                <img src="<?php echo $cliente['foto']?>" alt="Foto cliente">
            
            <?php

        }
        echo '</div>';
    }
/**
 * Función que elimina la foto actual y la remplaza por una silueta
 */
function eliminarFoto($conexion){
//Inicializamos variables y le damos valor
    $rutaSilueta='./fotos/silueta.jpg';
    $idEliminar=array();
    $idEliminar=array_keys($_POST['eliminar']);
/**
 * Creamos una consulta donde los parametros son interrograciones
 * (más facil la integración de variables en la consulta),preparamos la consulta,
 * bind_paran se le agragan ss dependiendo de los parametros que le vamos a incluir
 * y se le añaden las variables para la consulta y por ultimo se ejecuta la sentencia
 * */    
    $query='UPDATE infoClientes SET foto= ? WHERE ID= ?';
    $incluirVariables=$conexion->prepare($query);
    $incluirVariables->bind_param('ss',$rutaSilueta,$idEliminar[0]);
    $incluirVariables->execute();

}

function cambiarFotoCliente($conexion){
//Inizializamos variables y le damos valor
    $idModificarImagen=array();
    $idModificarImagen=array_keys($_POST['subirArchivo']);
    
    $archivo=$_FILES['archivo']['name'];
    $tipo=$_FILES['archivo']['type'];
    $peso=$_FILES['archivo']['size'];
    $carpetaTemporal=$_FILES['archivo']['tmp_name'];

    $mimeType=array('image/png','image/jpg','image/jpeg','image/webp');
    $PesoFotoMaxBytes=1048576 ;
    $rutaCarpetaImagen='./fotos';
    $rutaFoto=$rutaCarpetaImagen."/".$archivo;

//Comprobamos que el archivo exista y no esté vacío
if(isset($archivo) && $archivo!=""){
    
//Comprobamos que el tipo de foto se encuentre en la variable y el peso de la foto
if(in_array($tipo,$mimeType)&& $peso < $PesoFotoMaxBytes ){

/**
 * Para poder ejecutar esta linea tendría que cambiar los permisos del
 * safe_mode en el ini_set() y no veo seguro que me puedan modificar los permisos de las
 * carpetas desde un script
 */
   // exec('sudo chmod 777 /opt/lampp/htdocs/sanchez_Gonzalez_Patricia_DWES_Tarea02/TAREA1.4/fotos');

//Movemos el archivo de carpeta   
    move_uploaded_file($carpetaTemporal,$rutaFoto);

/**
 * Creamos una consulta donde los parametros son interrograciones
 * (más facil la integración de variables en la consulta),preparamos la consulta,
 * bind_paran se le agragan ss dependiendo de los parametros que le vamos a incluir
 * y se le añaden las variables para la consulta y por ultimo se ejecuta la sentencia
 * */  
    $query='UPDATE infoClientes SET foto= ? WHERE ID= ?';
    $incluirVariables=$conexion->prepare($query);
    $incluirVariables->bind_param('ss',$rutaFoto,$idModificarImagen[0]);
    $incluirVariables->execute();

}
else{

    echo '<span>El archivo que se ha insertado no es una imagen pruebelo 
    de nuevo con un archivo con alguna de estas extenciones(jpg, jpeg, png, webp)</span>';
}

}
}