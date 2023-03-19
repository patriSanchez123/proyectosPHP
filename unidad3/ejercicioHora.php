<?php 
session_start();

if(isset($_SESSION['hora'])){

array_push($_SESSION['hora'],date(DATE_RFC2822));
}else{

$_SESSION['hora']="";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horas</title>
</head>
<body>
    <?php 
    
    $horas=$_SESSION['hora'];
    foreach($horas as $valor){

        echo $valor. '<br>';
    }
    
    ?>
</body>
</html>