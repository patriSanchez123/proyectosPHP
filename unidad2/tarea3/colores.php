<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio colores</title>
    <link rel="stylesheet" href="./css/estilo.css">
   
</head>
<body>

    
    <?php 
    //Mostramos los errores
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    //Requerimos documentos
    require_once("./funciones.inc.php");
    //Inicializamos variables
    $arrayTabla=array();
    $desSerializar=array();
    
    if(isset($_POST['crearTabla']) && 
    (isset($_POST['fila'])&& !empty($_POST['fila'])) &&
    (isset($_POST['columna'])&& !empty($_POST['columna']))){
        creartabla($arrayTabla);
    }
    if((isset($_POST['color']))){
        $desSerializar=unserialize($_POST['array']);
        recorrerTablaCreada($desSerializar);
        contarColores($desSerializar);
    }        
        
       
    if(!isset($_POST['crearTabla'])){   
    ?>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <for id="filas">Filas<input type="number" name="fila" id="fila" min="1" max="40" ></for>
    <for id="columna">Columnas<input type="number" name="columna" id="columna" min="1" max="40"></for>
    <input type="submit" name=crearTabla value="Crear tabla">
</form>
<?php } else{
?>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <input type="submit" value="Total de cuadrados Rojos" name="color['rojo']">
    <input type="submit" value="Total de cuadrados Azul" name="color['azul']">
    <input type="submit" value="Total de cuadrados Verdes" name="color['verde']">
    <input type="hidden" name=array value="<?php echo serialize($arrayTabla)?>">
    </form>
<?php }?>
</body>
</html>



