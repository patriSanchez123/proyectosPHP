<?php
require_once('./funciones.inc.php');
function mostrarjuego(){
    global $tableroJuego;
    foreach($tableroJuego as $valorTablero){
        echo '<tr>';
        foreach($valorTablero as $valor){

            echo '<td>'.$valor.'</td>';
        }
        echo '</tr>';
    }

function jugadorQueEmpieza(){

    $empezar=array(1,2);

    $aleatorio=rand(1,2);

    if($aleatorio==0){
        //empieza Usuario
        $empieza=1;
        return $empieza;
    }else{
        //empieza pc
        $empieza=1;
        return $empieza;
    }

}
function comprobarPosicion($fila,$columna,){
    global $tableroJuego;
    $insertadoCorrecto=true;
    if($tableroJuego[$fila-1][$columna-1]=="."){
        $insertadoCorrecto=true; 
        return $insertadoCorrecto;
    }else{
        $insertadoCorrecto=false; 
        return $insertadoCorrecto;
    }    
}
}
function modificar($columna,$fila,$valor){
    $tableroJuego[$columna][$fila]=$valor;
}