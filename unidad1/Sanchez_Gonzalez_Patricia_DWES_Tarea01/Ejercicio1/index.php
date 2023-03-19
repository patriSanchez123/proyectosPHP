<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index1</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './FuncionesSudokus.inc.php';
require_once './DefinicionesSudokus.inc.php';

   if(isset($_POST['elegir']) && isset($_POST['nivelSudoku']) && !empty($_POST['nivelSudoku'])){
    
    
    switch($_POST['nivelSudoku']){
        case 1:
            echo '<div class="tb">';
            echo '<p>Fácil</p>';
            echo '<table>';
            mostrarSudoku($sudokuFacil);
            echo '</table>';
            echo '</div>';
            break;

        case 2:
            echo '<div class="tb">';
            echo '<p>Medio</p>';
            echo '<table>';
            mostrarSudoku($sudokuMedio);
            echo '</table>';
            echo '</div>';
            break;

            case 3:
                echo '<div class="tb">';
                echo '<p>Difícil</p>';
                echo '<table>';
                mostrarSudoku($sudokuDificil);
                echo '</table>';
                echo '</div>';
                break;

    }

}else{?>
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
        <div class="formularios">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="facil">
            <input type="radio" id="facil" value="1" name="nivelSudoku" checked/>  Fácil  </label>
            <label for="Medio">
            <input type="radio" id="Medio" value="2" name="nivelSudoku" />  Medio  </label>
            <label for="dificil">
            <input type="radio" id="dificil" value="3" name="nivelSudoku"/>  Difícil  </label>
            <input type="submit" value="Elegir" name="elegir"/>
            </form>
       
    <div>
    <?php
    }
    ?>





</body>
</html>