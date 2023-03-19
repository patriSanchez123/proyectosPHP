<?php
//cuando tengamos que hacer uso de la base de 
//echo  __FILE__;
//define sirve para definir las constantes
//dirname da el directorio padre donde se encuentra el archivo o el directorio
define('RUTA_APP',dirname(dirname(__FILE__)));
//Datos para la conexion de la base de datos
define('DB_HOST','localhost');
define('DB_NAME','bbddpokemon');
define('DB_USER','root');
define('DB_PASSWORD','');