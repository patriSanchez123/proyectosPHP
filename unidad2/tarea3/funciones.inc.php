<?php 
//Variables globales
$colores=array('red','blue','green');

/**
 * Función que crea la imagen
 */
function creartabla(&$arrayTabla){
//Variales  
global $colores;
    $fila= $_POST['fila'];
    $columna=$_POST['columna'];
//creamos la tabla con los colores aleatorio
    for ($i=0; $i < $fila ; $i++) { 
            
        for ($j=0; $j < $columna ; $j++) { 
            $numero_aleatorio = rand(0,2);
            $arrayTabla[$i][$j]=$numero_aleatorio;
        }
    }
    //Visualizamos la tabla,donde le color va dependiendo del valor de la tabla
    echo '<div class="tb">';
    echo '<table>';
       foreach($arrayTabla as $valorTabla){
            echo '<tr>';
            foreach($valorTabla as $valor){
                echo '<td bgcolor="'.$colores[$valor].'"></td>';
            }
            echo '</tr>';
       } 
       echo'</table>';
        }
      /**
       * Visualizamos la tabla creada */  
      function recorrerTablaCreada($arrayTabla){
        global $colores;
        echo '<table>';
       foreach($arrayTabla as $valorTabla){
            echo '<tr>';
            foreach($valorTabla as $valor){
                echo '<td bgcolor="'.$colores[$valor].'"></td>';
            }
            echo '</tr>';
       } 
       echo'</table>';
       echo '</div>';

      }
      /**
       * Función que cuenta los colores de la tabla, e imprime el color
       * dependiendo del indice de la variable color
       */
      function contarColores($arrayTabla){
        //Inicializamos las variables
        $rojo=0;
        $verde=0;
        $azul=0;
        //Coje el valor del indice el array
        $key=array_keys($_POST['color']);
        //Recorremos la tabla y le damos valor a las variables autoincrementandolas
          foreach($arrayTabla as $valorTabla){
            
             foreach($valorTabla as $valor){
                if($valor==0){
                     $rojo++;
                 }
                 elseif($valor==1){
                  $azul++;
                  }elseif($valor==2){
                    $verde++;
              }
            }
          }
      //Dependiendo del indice de color retorna una cosa o otra
          switch($key[0]){

            case "'rojo'":
              echo 'El tiene un total de color rojo: '. $rojo;
              break;
            case "'azul'":
              echo 'El tiene un total de color rojo: '. $azul;
              break;
            case "'verde'":
              echo 'El tiene un total de color rojo: '.$verde;
              break;  
          }   
        }

        

    