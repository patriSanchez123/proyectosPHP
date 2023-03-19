<?php
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  
  include("./templates/header.tpl.php");
  
  include("./funciones.php");
  
  if(!isset($_SESSION['formulario']['productos'])||empty($_SESSION['formulario']['productos'])){
    include("./vars.php");
    inicializa_productos($_SESSION['formulario']['productos'], 4);

  }

  //Gestión del POST
  if(isset($_POST['anterior'])){
    $_SESSION['formulario']['paso_actual'] = $_SESSION['formulario']['paso_actual']-1;
  }else if(isset($_POST['siguiente'])){
    //$_SESSION['formulario']['productos'][$_SESSION['formulario']['paso_actual']]['cantidad'] = $_POST['cantidad'];
    $_SESSION['formulario']['paso_actual'] = $_SESSION['formulario']['paso_actual']+1;
  }
  //Imprimimos los que corresponda
  imprime_formulario($_SESSION['formulario']);

  include("./templates/footer.tpl.php");
?>

