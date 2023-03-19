<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo 'entra';
if(!isset($_COOKIE['contador'])){
    //el ultimo digito son los dias
    setcookie('contador',1,time()+60*60*24*1);
    
}
elseif(isset($_COOKIE['contador']) && $_COOKIE['contador']==1){

    $hora=date(DATE_RFC2822);

    // setcookie('contador',$contador,time()+60*60*24*1);
    //Aqui no existe todavia la cookie hay que imprimir la varible
     setcookie('hora',$hora,time()+60*60*24*1);
    $contador=$_COOKIE['contador']+1;
    setcookie('contador',$contador,time()+60*60*24*1);
    echo $hora;
    
}
else{
    //aqui ya está establecida
    echo $_COOKIE['hora'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>