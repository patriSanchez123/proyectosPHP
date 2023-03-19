<?php

function getPrimaryKey($connection){
  //Primero hacíamos un select de todos los ids de los departamentos ordenados
  
  if($results = $connection->query('SELECT dept_no FROM departments ORDER BY dept_no DESC')){
    $array_results = $results->fetch_array();
    $dept_no = reset($array_results);
    $matches=array();
    preg_match('/d([0-9]{3})/', $dept_no , $matches, PREG_OFFSET_CAPTURE);
    $dept_no = reset($matches[1]);
    $dept_no = $dept_no + 1;
    
    $dept_no = sprintf("%'.03d", $dept_no);
        
    return 'd'.$dept_no; 
  }
  
 

}
