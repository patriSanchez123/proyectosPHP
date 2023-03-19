<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de tableros</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php 
//Mostar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Incluye los archivos y verifica si al archivo ha sido incluido y si esí no lo incluye
require_once './FuncionesSudokus.inc.php';
require_once './DefinicionesSudokus.inc.php';
?>
   <!--Mostrar tutulos de dificultad y tablero correspondiente-->
     <div id="tablas">
        <div class="tbl">
            <p>Fácil</p>
        <table>
        <?php mostrarSudoku($sudokuFacil);?>
        </table>
        </div>
        <div class="tbl">
            <p>Medio</p>
        <table>
        <?php mostrarSudoku($sudokuMedio);?>
        </table>
        </div>
        <div class="tbl">
            <p>Difícil</p>
        <table>
        <?php mostrarSudoku($sudokuDificil);?>
        </table>
        </div>
        </div>
        <!--Mostrar formulario-->
        <div class="formularios">
            <form action="./index2.php" method="post">
            <label for="facil">
            <input type="radio" id="facil" value="1" name="nivelSudoku" checked/>  Fácil  </label>
            <label for="Medio">
            <input type="radio" id="Medio" value="2" name="nivelSudoku" />  Medio  </label>
            <label for="dificil">
            <input type="radio" id="dificil" value="3" name="nivelSudoku"/>  Difícil  </label>
            <input type="submit" value="Elegir" name="elegir"/>
            </form>
       
    <div>




</body>
</html>