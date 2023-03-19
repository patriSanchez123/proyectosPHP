<?php

// Iniciamos la sesión o recuperamos la anterior sesión existente
session_start();
// Comprobamos si la variable ya existe
if (isset($_SESSION['visitas'])){
$_SESSION['visitas']++;

}else{
$_SESSION['visitas'] = 0;
}
if(isset($_SESSION['nombre']) && isset($_POST['nombre'])){
    $_SESSION['nombre']=$_POST['nombre'];
}

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas Cookies</title>
</head>
<body>
<?php 
      echo $_SESSION['visitas'];
      echo $_SESSION['nombre'];
      echo  date(DATE_RFC2822);
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<label for="nombre">Nombre<input type="text" name=nombre id=nombre></label>
</form>
       

</body>
</html>