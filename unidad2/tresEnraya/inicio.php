<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo.css">
    <title>Tres en raya</title>
</head>
<body>
    <?php 
    require_once('./funciones.inc.php');
    require_once('./tablero.inc.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $empieza=jugadorQueEmpieza();
    
    if(isset($_POST['empezar'])){?>

       <?php mostrarjuego();?>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="number" name="columna[]" value="Empezar" required pattern="[1-9]">
    <input type="number" name="fila[<?php ?>]" value="Empezar" required pattern="[1-9]">

    <?php } ?>

    <?php if(!isset($_POST['empezar'])){?>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="submit" name="empezar" value="Empezar">
</form>
<?php }?>
</body>
</html>


