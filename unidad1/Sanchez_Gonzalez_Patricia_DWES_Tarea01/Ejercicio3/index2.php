<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Tablero de juego</title>
</head>
<body>
<?php
//comprobación de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Incluye los archivos y verifica si al archivo ha sido incluido y si esí no lo incluye
require_once './FuncionesSudokus.inc.php';
require_once './DefinicionesSudokus.inc.php';
//Declaraciones de variables
$tableroDeJuego;
$tituloNivelSudoku;
$numerosCandidatos;
$numeroFila=array();
$numeroColumna=array();
//Comprueba que exista elegir
if(isset($_POST['elegir'])){
   
    //En este switch imprimimos el nivel del sudoku selecionado y le damos valor a las variables
    switch($_POST['nivelSudoku']){
        case 1:
            echo '<div class="tb">';
            echo '<p>Fácil</p>';
            echo '<table>';
            mostrarSudoku($sudokuFacil);
            echo '</table>';
            echo '</div>';
            $tableroDeJuego=$sudokuFacil;
            $tituloNivelSudoku="Fácil";
            break;

        case 2:
            echo '<div class="tb">';
            echo '<p>Medio</p>';
            echo '<table>';
            mostrarSudoku($sudokuMedio);
            echo '</table>';
            echo '</div>';
            $tableroDeJuego=$sudokuMedio;
            $tituloNivelSudoku="Medio";

            break;

        case 3:
            echo '<div class="tb">';
            echo '<p>Dificil</p>';
            echo '<table>';
            mostrarSudoku($sudokuDificil);
            echo '</table>';
            echo '</div>';
            $tableroDeJuego=$sudokuDificil;
            $tituloNivelSudoku="Dificíl";
                break;
    }?>
    <!--Imprime el formulario donde los type hidden se les da el valor de las variables que posteriormente usaremos
    también serializamos el array para enviarlo codificado, le añadido un patron para que el usuario no pueda insertar cualquier
        digito he puesto columna y fila como requerido ya que siempre se requiere para hacer cualquiera de las opciones
    PERO EN INSERTAR DA FALLO SI NO SE  LE INTRODUCE UN DIGITO, NO ENTIENDO POR QUE ENTRA EN LA VERIFICACIÓN DE INSERTAR YA QUE EL VALOR 
    TENDRIA QUE SER NULO, no he querido poner numero como requerido ya que realmente solo se requiere para insertar-->
    <div class=form>
    <form action="./index2.php" method="post">
    <label for="numero">Número
        <input type="text" name="numero" id="numero" pattern="[0-9]" title="Introduce un numero de 1 al 9"></label><br>
    <label for="fila">Fila
        <input type="text" name="fila" id="fila" required pattern="[0-9]" title="Introduce un numero de 1 al 9"></label><br>
    <label for="columna">Columna
        <input type="text" name="columna" id="columna" required pattern="[0-9]" title="Introduce un numero de 1 al 9"></label><br>
        <input type="submit" value="Insertar" name="insertar"><br>
        <input type="submit" value="Eliminar" name="eliminar"><br>
        <input type="submit" value="Candidatos" name="candidatos"><br>
        <input type="hidden" name="sudokuSerializado" value="<?php echo base64_encode(serialize($tableroDeJuego)); ?>">
        <input name="tituloNivelSudoku" type="hidden" value="<?php echo $tituloNivelSudoku?>">                                                        
<?php 
  //Se verifica que exista insertar y las variables nesesarias para introdución de datos 
}elseif(isset($_POST['insertar']) && isset($_POST['columna']) && isset($_POST['fila'])
        && !empty($_POST['columna']) && !empty($_POST['fila']) && isset($_POST['numero'])
        && !empty($_POST['numero']) &&  isset($_POST['sudokuSerializado'])
        && !empty($_POST['sudokuSerializado']) && isset($_POST['tituloNivelSudoku'])
        && !empty($_POST['tituloNivelSudoku'])){
    //Deserializamos el sudoku en un nuevo tablero y igualamos la variable el titulo del sudoku       
    $tableroDeJuego=unserialize(base64_decode($_POST['sudokuSerializado']));
    $tituloNivelSudoku=$_POST['tituloNivelSudoku'];
    //Función para insertar datos
    insertarNumero($tableroDeJuego,$tituloNivelSudoku);
    
//Se verifica que exista eliminar y las variables nesesarias para introdución de datos 
}elseif(isset($_POST['eliminar']) && isset($_POST['columna']) && isset($_POST['fila'])
&& !empty($_POST['columna']) && !empty($_POST['fila'])&&  isset($_POST['sudokuSerializado'])
&& !empty($_POST['sudokuSerializado']) && isset($_POST['tituloNivelSudoku'])
&& !empty($_POST['tituloNivelSudoku'])){

//deserializamos sudoku
$tableroDeJuego=unserialize(base64_decode($_POST['sudokuSerializado']));
$tituloNivelSudoku=$_POST['tituloNivelSudoku'];
//funcioón para eliminar
eliminarNumero($tableroDeJuego,$tituloNivelSudoku);

//Se verifica que exista eliminar y las variables nesesarias para introdución de datos 
}elseif(isset($_POST['candidatos']) && isset($_POST['columna']) && isset($_POST['fila'])
&& !empty($_POST['columna']) && !empty($_POST['fila'])&&  isset($_POST['sudokuSerializado'])
&& !empty($_POST['sudokuSerializado']) && isset($_POST['tituloNivelSudoku'])
&& !empty($_POST['tituloNivelSudoku'])){
//Deserializamos el sudoku en el tablero
$tableroDeJuego=unserialize(base64_decode($_POST['sudokuSerializado']));
$tituloNivelSudoku=$_POST['tituloNivelSudoku'];
?>
<?php }
//Inserto este if para que el codigo insertar,eliminar y candidatos no tenga que repetir el codigo
if(isset($_POST['sudokuSerializado'])&& !empty($_POST['sudokuSerializado'])
     && isset($_POST['tituloNivelSudoku'])&& !empty($_POST['tituloNivelSudoku'])){
     echo '<div class="tb">';
     echo '<p>'.$_POST['tituloNivelSudoku'].'</p>';
     echo '<table>';
     mostrarTableroDejuego($tableroDeJuego,$tituloNivelSudoku);
     echo '</table>';
     echo '</div>';

?>
<!--Creo un nuevo formulario que lo utilizaran las condicionales de verificación-->
<div class=form>
    <form action="./index2.php" method="post">
    <label for="numero">Número
        <input type="text" name="numero" id="numero"  pattern="[0-9]"></label><br>
    <label for="fila">Fila
        <input type="text" name="fila" id="fila" required pattern="[0-9]"></label><br>
    <label for="columna">Columna
        <input type="text" name="columna" id="columna" required pattern="[0-9]"></label><br>
        <input type="submit" value="Insertar" name="insertar"><br>
        <input type="submit" value="Eliminar" name="eliminar"><br>
        <input type="submit" value="Candidatos" name="candidatos">
        
        <?php if(isset($_POST['candidatos']) && isset($_POST['columna']) && isset($_POST['fila'])
                && !empty($_POST['columna']) && !empty($_POST['fila'])&&  isset($_POST['sudokuSerializado'])
                && !empty($_POST['sudokuSerializado']) && isset($_POST['tituloNivelSudoku'])
                && !empty($_POST['tituloNivelSudoku'])){

                candidatos($tableroDeJuego,$tituloNivelSudoku);}?> <br>

        <input type="hidden" name="sudokuSerializado" value="<?php echo base64_encode(serialize($tableroDeJuego)); ?>">
        <input name="tituloNivelSudoku" type="hidden" value="<?php echo $tituloNivelSudoku?>"> 

    <br>
<?php } ?>
    </form>

    </div>
    
</body>
</html>


