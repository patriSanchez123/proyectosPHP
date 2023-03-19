<?php 

function claveDepartamentos($conexion){
    $incrementoClave="";

    //Toma el último que ingresa en el select
    $consulta=$conexion->query ("SELECT dept_no FROM departments ORDER BY dept_no DESC LIMIT 1");
    
    $consultaClave=$consulta->fetch_array();
     $clave=$consultaClave['dept_no'];

        for ($i=1; $i < 4 ; $i++) { 
            $incrementoClave.=$clave[$i];
        }
        intval($incrementoClave);
        $incrementoClave++;
        if($incrementoClave<10){

            $claveParaDepartamento="d00".$incrementoClave;
        }
        elseif($incrementoClave>9 && $incrementoClave<100){
            $claveParaDepartamento="d0".$incrementoClave;

        }elseif($incrementoClave>99){
            $claveParaDepartamento="d".$incrementoClave;
        }

     
     return $claveParaDepartamento;
}