<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Index</title>
</head>
<body>
    <?php 
    require_once('./funciones.inc.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);?>
   
    <form action="./mostrarTabla.php" method="post">
    <label for="host">Host<input type="text" id="host" name="host"></label>
    <label for="nombreUsuario">Nombre Usuario<input type="text" id="nombreUsuario" name="nombreUsuario"></label>
    <label for="pass">Contraseña<input type="text" id="pass" name="pass" placeholder=""></label>
    <label for="base">Base de datos<input type="text" id="base" name="base"></label><br>
        <input type="submit" id="mostrar" name="mostrar"><br>
    </form>

</form>
</body>
</html>