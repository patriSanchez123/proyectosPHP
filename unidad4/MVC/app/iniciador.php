<?php
//Incluimos los archivos en el script
require_once('./app/config/config.php');
//require_once('./app/core.php');
session_start();

//Lanza exepción si hay alguntipo de fallo en el código
spl_autoload_register(function ($nombre_clase) {

  $nameFile = "";
  $encontrado="false";
//recorre el String del nombre de clase
  for ($i = 0; $i < strlen($nombre_clase); $i++) {
//si hay alguna letra en mayuscula o algun numero añade "_" detras del mismo no se puede añadir "_" ni en el primer 
//indice ni en el ultimo
    if ((preg_match("/[A-Z]|[0-9]/", $nombre_clase[$i]) && ($i > 0 && $i < strlen($nombre_clase) - 1))) {
      $nameFile = $nameFile . "_";
    }
    $nameFile = $nameFile . $nombre_clase[$i];
  }
  //Se crea un patron para la busqueda donde todo es en minuscula
  $regex = strtolower($nameFile) . ".php";
//se crea un iterador con el arbol de rutas
  $it = new RecursiveTreeIterator(new RecursiveDirectoryIterator(RUTA_APP, RecursiveDirectoryIterator::SKIP_DOTS));
  //recorremos las rutas
  foreach ($it as $path) {
    $filePath = "";
    //guardamos el indice del primer caracter de la ruta
    $primerCaracterValido = strpos($path, "/");
//lo recorremos el String y lo montamos de nuevo desde el inicio de la ruta
    for ($i = $primerCaracterValido; $i < strlen($path); $i++) {
      $filePath .= $path[$i];
    }

//comprueba si existe el archivo en las rutas y hace un require
    if ((preg_match("/$regex/", $path) == 1)) {
      $encontrado=true;
      require_once($filePath);
    }
  }
  if(!$encontrado){
    throw new Exception("La clase " .$nameFile ."no existe");
  }
  
});


try {
  $iniciador = new Core();
} catch (Exception $e) {
  //Si hay algún tipo de fallo se lanza la cabecera  con el fallo de la página
  header("HTTP/1.0 404 Not Found");
  die($e->getMessage());
}
