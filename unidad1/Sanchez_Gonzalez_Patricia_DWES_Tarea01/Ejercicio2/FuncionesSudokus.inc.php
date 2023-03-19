<?php 
require_once './DefinicionesSudokus.inc.php';
$NUMERO_MAX=9;
$INDICE_MAXIMO_ARRAY_SUDOKU=8;
$numerosCandidatos=array();

/**
 * Función que muestra el tablero de juego dependiendo del nivel.' 
 */
function mostrarTableroDejuego($tableroDeJuego,$tituloNivelSudoku){
    global $sudokuFacil,$sudokuMedio,$sudokuDificil;
    //Comparamos el nivel del tablero
    if($tituloNivelSudoku=='Fácil')
    //Recorremos el los arrays para poder modicarlos
    for ($i=0; $i < 9; $i++) { 
        echo "<tr>";//creamos colunma 
        for ($j=0; $j < 9; $j++) { 
            //Si el valor del tablero de juego es igual 0 modifica el valor
            if($tableroDeJuego[$i][$j]=='0'){
                $tableroDeJuego[$i][$j]=".";
            }
            //si el valor de sudokuFacil es 0 añade color azul al tablero
            if($sudokuFacil[$i][$j]=='0'){
            
            echo "<td style='color:blue'>".$tableroDeJuego[$i][$j]."</td>";
            }
            else{
                //si el valor de sudokuFacil es 0 añade color rojo al tablero
                echo "<td style='color:red'>".$tableroDeJuego[$i][$j]."</td>";
            }  
        }
    }
    if($tituloNivelSudoku=='Medio')
    for ($i=0; $i < 9; $i++) { 
        echo "<tr>";//creamos colunma 
        for ($j=0; $j < 9; $j++) { 
            if($tableroDeJuego[$i][$j]=='0'){
                $tableroDeJuego[$i][$j]=".";
            }
            if($sudokuMedio[$i][$j]=='0'){
            
            echo "<td style='color:blue'>".$tableroDeJuego[$i][$j]."</td>";
            }
            else{
                echo "<td style='color:red'>".$tableroDeJuego[$i][$j]."</td>";
            }  
        }
    }
    if($tituloNivelSudoku=='Difícil')
    for ($i=0; $i < 9; $i++) { 
        echo "<tr>";
        for ($j=0; $j < 9; $j++) { 
            if($tableroDeJuego[$i][$j]=='0'){
                $tableroDeJuego[$i][$j]=".";
            }
            if($sudokuDificil[$i][$j]=='0'){
            
            echo "<td style='color:blue'>".$tableroDeJuego[$i][$j]."</td>";
            }
            else{
                echo "<td style='color:red'>".$tableroDeJuego[$i][$j]."</td>";
            }  
        }
    }
    //cerramos columna
    echo "</tr>";
}

/**
 * Función que muestra cualquier sudoku, sin tener la variable tituloNivelSudoku
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


/**
 * Función que inserta numero al tablero de juego y da un mensaje al usuario si quiere insertar un
 * numero en una posición original
 * Esa función contiene variable de referencia, para poder modificar el valor 
 */
function insertarNumero(&$tableroDeJuego,$tituloNivelSudoku){
    //Comprueba que se inserte en una posición correcta
    if(comprobarPosiscionesOriginales($tituloNivelSudoku)){
        //Si es correcta modifica el valor del tablero
        $tableroDeJuego[$_POST['columna']-1][$_POST['fila']-1]=$_POST['numero'];   
    } else{
        //Mensaje que no se puede modificar la posición
        echo '<p><strong>La posición seleccionada no se puede insertar, pruebe con una posción correcta</strong></p>';
}
   
         
}

/**
 * Función que elimna numero al tablero de juego y da un mensaje al usuario si quiere eliminar un
 * numero en una posición original
 * Esa función contiene variable de referencia, para poder modificar el valor 
 */
function eliminarNumero(&$tableroDeJuego,$tituloNivelSudoku){
    //Comprueba que se elimine una posición correcta
    if(comprobarPosiscionesOriginales($tituloNivelSudoku)){
        //La posición que va a ser eliminada  de iguala a 0
        $tableroDeJuego[$_POST['columna']-1][$_POST['fila']-1]=0;   
    } else{
        //Mensaje que no se puede eliminar la posición
        echo '<p><strong>La posición seleccionada no se puede eliminar, pruebe con una posción correcta</strong></p>';
}

}

/**
 * Función que comprueba si la posición seleccionada se encuentra una posición original
 */
function comprobarPosiscionesOriginales($tituloNivelSudoku){
    //Declaración de variables
    $comprobarSudokuOriginal=true; 
    global $sudokuFacil,$sudokuMedio,$sudokuDificil;

    //Comprueba el nivel del tablero de juego si la posición es igual a 0 devuelve true y si es distinta a 0 devuelve false

    if($tituloNivelSudoku=="Fácil"){
        if($sudokuFacil[$_POST['columna']-1][$_POST['fila']-1]=='0'){
                return $comprobarSudokuOriginal;

            }
            else{
                return $comprobarSudokuOriginal=false;
            }

        
    }
    elseif($tituloNivelSudoku=="Medio"){
        if($sudokuMedio[$_POST['columna']-1][$_POST['fila']-1]=='0'){
            return $comprobarSudokuOriginal;

        }
        else{
            return $comprobarSudokuOriginal=false;
        }
        
} elseif($tituloNivelSudoku=="Difícil"){
    if($sudokuDificil[$_POST['columna']-1][$_POST['fila']-1]=='0'){
        return $comprobarSudokuOriginal;

    }
    else{
        return $comprobarSudokuOriginal=false;
    }
}
}
/**
 * Función que devuelve los numeros de una fila dependiendo de la columna que se inserte
 */
function numerosFila($tableroDeJuego){
    //Inicializamos variable
    $numerosFila=array();
//recorremos las filas de la columna para poder insertar los numeros en un  array siempre que la posición sea diferente a 0
for ($i=0; $i <=8 ; $i++) { 
    if($tableroDeJuego[$_POST['columna']-1][$i]!='0'){
        //array_push inserta valores al array
        array_push($numerosFila, $tableroDeJuego[$_POST['columna']-1][$i]);
            
    }
}
return $numerosFila;     
}

/**
 * Función que devuelve los numeros de una columna dependiendo de la fila que se inserte
 */
function numerosColumna($tableroDeJuego){
    //Inicializamos variable del array
    $numerosColumna=array();
//recorremos las columnas de la fila para poder insertar los numeros en un  array siempre que la posición sea diferente a 0
    for ($i=0; $i <=8 ; $i++) { 
        
        if($tableroDeJuego[$i][$_POST['fila']-1]!='0'){
            //array_push inserta valores al array
            array_push($numerosColumna, $tableroDeJuego[$i][$_POST['fila']-1]);
                
        }   
    }
    return $numerosColumna;
}
   
/**
 * Función que comprueba en que cuadrante se encuentra dependiendo de la fila y columna
 * que indique el usuario, una vez comprobado donde se encuentra se recogen los numero que se 
 * encuentran en el cuadrante**/
function numerosCuadrantes($tableroDeJuego){
//inicializamos variable
$numerosCuadrantes=array(); 

/**Comprobación de las posiciones dependiendo de las posiciones que se inserten entrara en una condicón diferente 
 * cunado entre en una condición recorrera el tablero de juego e insertara los numeros del cuadrante en una variable
 */

//cuandrante 1(fila(0,2)columna(0,2))
if((($_POST['columna']-1 )>=0) && (($_POST['columna']-1) <=2) && 
    (($_POST['fila']-1) >=0) && (($_POST['fila']-1)<=2)){

for ($columna=0; $columna < 3; $columna++) { 
    for ($fila=0; $fila < 3; $fila++) { 
        if($tableroDeJuego[$columna][$fila]!=0){
            //array push es para insertar un valor en el array
            array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
         
        }
    }
}
return $numerosCuadrantes;

//cuandrante 1(fila(0,2)columna(3,5))
}elseif((($_POST['columna']-1 )>=0) && (($_POST['columna']-1) < 3) && 
(($_POST['fila']-1) >2) && (($_POST['fila']-1)<6)){

for ($columna=0; $columna < 3 ; $columna++) { 
for ($fila=3; $fila < 6; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
         }
    }
}
return $numerosCuadrantes;

//cuandrante 2(fila(0,2)columna(6,8))
}elseif((($_POST['columna']-1 )>=0) && (($_POST['columna']-1) < 3) && 
(($_POST['fila']-1) > 5) && (($_POST['fila']-1) < 9)){

for ($columna=0; $columna < 3; $columna++) { 
for ($fila=6; $fila < 9; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
        }
    }
}

return $numerosCuadrantes;

//cuandrante 3(fila(3,5)columna(0,2))
}elseif((($_POST['columna']-1 ) > 2) && (($_POST['columna']-1) < 6) && 
(($_POST['fila']-1) >=0) && (($_POST['fila']-1) < 3)){

for ($columna=3; $columna < 6; $columna++) { 
for ($fila=0; $fila < 3; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
        }
    }
}
return $numerosCuadrantes;

//cuandrante 4(fila(3,5)columna(3,5))
}elseif((($_POST['columna']-1 )> 2) && (($_POST['columna']-1) < 6) && 
(($_POST['fila']-1) > 2) && (($_POST['fila']-1)< 6)){

for ($columna=3; $columna < 6; $columna++) { 
for ($fila=3; $fila < 6; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
        }
    }
}

return $numerosCuadrantes;

//cuandrante 5(fila(3,5)columna(6,8))
}elseif((($_POST['columna']-1 )>2) && (($_POST['columna']-1) < 6) && 
(($_POST['fila']-1)>5) && (($_POST['fila']-1)<9)){

for ($columna=3; $columna < 6; $columna++) { 
for ($fila=6; $fila < 9; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
         }
    }
}

return $numerosCuadrantes;

//cuandrante 6(fila(6,8)columna(0,2))
}elseif((($_POST['columna']-1 )>5) && (($_POST['columna']-1) < 9) && 
(($_POST['fila']-1) >=0) && (($_POST['fila']-1)< 3)){

for ($columna=6; $columna < 9; $columna++) { 
for ($fila=0; $fila < 3; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
        }
    }
}

return $numerosCuadrantes;

//cuandrante 7(fila(6,8)columa(3,5))
}elseif((($_POST['columna']-1 )>5) && (($_POST['columna']-1) <9) && 
(($_POST['fila']-1) >2) && (($_POST['fila']-1)<6)){

for ($columna=6; $columna < 9; $columna++) { 
for ($fila=3; $fila < 6; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
        }
    }
}
 return $numerosCuadrantes;

//cuandrante 8(fila(6,8)columa(6,8))
}elseif((($_POST['columna']-1 )>5) && (($_POST['columna']-1) <9) && 
(($_POST['fila']-1) >5) && (($_POST['fila']-1)<9)){

for ($columna=6; $columna < 9; $columna++) { 
for ($fila=6; $fila < 9; $fila++) { 
    if($tableroDeJuego[$columna][$fila]!=0){
        array_push($numerosCuadrantes,$tableroDeJuego[$columna][$fila]);
     
        }
    }
}
 return $numerosCuadrantes;

    }
}
/**
 * Función que da los candidatos dependiendo columna y fila
 */
function candidatos($tableroDeJuego,$tituloNivelSudoku){
//Comprueba que la posición que se ja insertado sea correcta, si es correcta da los numeros candidatos si no da mensaje de error
    if(comprobarPosiscionesOriginales($tituloNivelSudoku)){
    
        $candidatos=array();
        /**Guardamos en un mismo array los numeros de columna,fila y cuadrantes que se encuentran el tablero */  
        $NumerosRepetidos=array_merge(numerosColumna($tableroDeJuego),numerosFila($tableroDeJuego),numerosCuadrantes($tableroDeJuego));
        //Quitamos los numeros que se encuentran repetidos
        $numerosNoRepetidos = array_unique($NumerosRepetidos);
       // Hacemos una comparación con los numeros que se pueden introducir en el tablero, los que no se encuentren
       //en los numerosNoRepetidos los insertamos en el array candidatos
       for ($i=1; $i <10 ; $i++) { 
   
           if(!in_array($i,$numerosNoRepetidos)){
           
               array_push($candidatos,$i); 
           }
       }
   
       foreach($candidatos as $valor){
   
           echo $valor." ";
       }
        
    } else{
        echo '<p><strong>La posición es por defecto, en esta posición no se pueden ver candidatos, pruebe con una posición correcta</strong></p>';
}
      
  
}
/**
 * Función que comprueba si el numero insertado existe en la fila
 */
function comprobarFila($tableroDeJuego){
    //Declación de variable
    $comprobarFila=true;
    //Recorremos la columna y se numero es igual a la posición devuelve false y si no se encuetra true
    for ($i=0; $i <=8 ; $i++) { 
        if($tableroDeJuego[$_POST['columna']][$i]==$_POST['numero']){
            $comprobarFila=false;

        }
    }
    return $comprobarFila;

}

/**
 * Función que comprueba si el numero insertado esta en la columna
 */
function comprobarColumna($tableroDeJuego){
    //Declaricón de variable
    $comprobarColumna=true;
    //Recorremos la fila y se numero es igual a la posición devuelve false y si no se encuetra true
    for ($i=0; $i <=8 ; $i++) { 
        if($tableroDeJuego[$i][$_POST['fila']]==$_POST['numero']){
            $comprobarColumna=false;
        }
    }
    return $comprobarColumna;

}
/**
 * Función que calcula el cuadrado que pertenece dependiendo de la posición
 */
function calcularCuadrado($columna,$fila){
    /**Dependidendo de la posición de la fila y la columna entra en una condición diferente donde nos indica el numero
     * del cuadrado que se encuentra
     */
    
        //cuandrante 0(fila(0,2)columna(0,2))
        if((($columna)>=0) && (($columna) <=2) && 
            (($fila) >=0) && (($fila)<=2)){
        
                return 0;
            
        //cuandrante 1(fila(0,2)columna(3,5))
        }elseif((($columna)>=0) && (($columna) < 3) && 
        (($fila) >2) && (($fila)<6)){
        
            return 1;
        
        //cuandrante 2(fila(0,2)columna(6,8))
        }elseif((($columna)>=0) && (($columna) < 3) && 
        (($fila) > 5) && (($fila) < 9)){
        
            return 2;
        
        //cuandrante 3(fila(3,5)columna(0,2))
        }elseif((($columna) > 2) && (($columna) < 6) && 
        (($fila) >=0) && (($fila) < 3)){
        
            return 3;
        
        //cuandrante 4(fila(3,5)columna(3,5))
        }elseif((($columna)> 2) && (($columna) < 6) && 
        (($fila) > 2) && (($fila)< 6)){
        
            return 4;
        
        //cuandrante 5(fila(3,5)columna(6,8))
        }elseif((($columna)>2) && (($columna) < 6) && 
        (($fila)>5) && (($fila)<9)){
        
            return 5;
        
        //cuandrante 6(fila(6,8)columna(0,2))
        }elseif((($columna)>5) && (($columna) < 9) && 
        (($fila) >=0) && (($fila)< 3)){
        
            return 6;
        
        //cuandrante 7(fila(6,8)columa(3,5))
        }elseif((($columna)>5) && (($columna) <9) && 
        (($fila) >2) && (($fila)<6)){
        
            return 7;
        
        //cuandrante 8(fila(6,8)columa(6,8))
        }elseif((($columna )>5) && (($columna) <9) && 
        (($fila) >5) && (($fila)<9)){
        
            return 8;
            }
        }
    
        /**
         * Función que devuelve la posición incial de la fila dependiendo del cuadrado que se encuentre
         */
        function CalcularFilaInicialCuadrado($columna,$fila){

            switch(CalcularCuadrado($columna,$fila)){

                case 0:
                    return 0;
                        break;

                case 1:
                    return 3;
                        break;
                        
                case 2:
                    return 6;
                        break;
                case 3;
                    return 0;
                        break;
                case 4:
                    return 3;
                        break;
                case 5:
                    return 6;
                        break;
                case 6:
                    return 0;
                        break;
                case 7:
                    return 3;
                        break;
                case 8:
                    return 6;
                        break;
            }


        }

        /**
         * Función que devuelve la posición final de la fila dependiendo del cuadrado que se encuentre
         */
        function CalcularFilaFinalCuadrado($columna,$fila){

            switch(CalcularCuadrado($columna,$fila)){

                case 0:
                    return 2;
                        break;
                case 1:
                    return 5;
                        break;      
                case 2:
                    return 8;
                        break;
                case 3;
                    return 2;
                        break;
                case 4:
                    return 5;
                        break;
                case 5:
                    return 8;
                        break;
                case 6:
                    return 2;
                        break;
                case 7:
                    return 5;
                        break;
                case 8:
                    return 8;
                        break;
            }
        }


        /**
         * Función que devuelve la posición inicial de la columna dependiendo del cuadrado que se encuentre
         */
        function CalcularColumnaInicialCuadrado($columna,$fila){

            switch(CalcularCuadrado($columna,$fila)){

                case 0:
                    return 0;
                        break;
                case 1:
                    return 0;
                        break;      
                case 2:
                    return 0;
                        break;
                case 3;
                    return 3;
                        break;
                case 4:
                    return 3;
                        break;
                case 5:
                    return 3;
                        break;
                case 6:
                    return 6;
                        break;
                case 7:
                    return 6;
                        break;
                case 8:
                    return 6;
                        break;
            }


        }


        /**
         * Función que devuelve la posición final de la columna dependiendo del cuadrado que se encuentre
         */
        function CalcularColumnaFinalCuadrado($columna,$fila){

            switch(CalcularCuadrado($columna,$fila)){

                case 0:
                    return 2;
                        break;
                case 1:
                    return 2;
                        break;      
                case 2:
                    return 2;
                        break;
                case 3;
                    return 5;
                        break;
                case 4:
                    return 5;
                        break;
                case 5:
                    return 5;
                        break;
                case 6:
                    return 8;
                        break;
                case 7:
                    return 8;
                        break;
                case 8:
                    return 8;
                        break;
            }


        }

        
    
    
                
    