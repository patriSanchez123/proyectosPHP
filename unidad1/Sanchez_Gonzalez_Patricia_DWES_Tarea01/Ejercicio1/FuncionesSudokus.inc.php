<?php 
//Incluimos archivos, y verifica si se ha incluido ya si es así no se encluye el archivo
require_once './DefinicionesSudokus.inc.php';

/**
 * Función que muestra el sudoku y lo modifica de color dependiendo de la posición
 */
function mostrarSudoku($sudoku){

foreach($sudoku as $clave=>$valorSudoku){
    echo "<tr>";//creamos colunma 
foreach($valorSudoku as $indice => $valor) {
    //Condición para cambiar valor de "0" a "."
    if($valor==0){
        $valor=($sudoku[$clave][$indice]='.');    
    }
// Creación de fila donde le ponemos color al valor dependiendo de su valor 
    echo "<td style='color:" . color($valor)."'>".$valor."</td>";
}
}
//cerramos la fila
echo "</tr>";
}
/**
 * Función que cambia de color el sudoku
 */
function color($valor){
    if($valor=="."){
        $color='blue';
        return $color;

    }
    else{
        $color='red';
        return $color;
    }
}

