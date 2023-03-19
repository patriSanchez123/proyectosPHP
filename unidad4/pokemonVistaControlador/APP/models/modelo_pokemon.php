<?php 
Class ModeloPokemon{

private $conexion;
private $tamanoPagina;


function __construct()
{
    $this->conexion=@ new PDO('mysql:host=localhost;dbname=bbddPokemon',"root", "");
}

public function GetPOkemon(){
    try {
foreach($this->conexion->query('SELECT * from pokemon') as $fila) {
        print_r($fila);
    }
    $this->conexion = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
}

}