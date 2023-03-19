<?php

class ModeloPokemon{
    
    private $host = DB_HOST;
    private $usuario = DB_USER;
    private $password = DB_PASSWORD;
    private $nombre_base = DB_NAME;

    private $manejador_conexion; 
    private $manejador_query;

    public function __construct(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->nombre_base;
        //Explicar en qué contexto puede ser útil la conexión persistente tal y como se crea.
        $opts = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        //Explicar por qué hemos decidido no utilizar aquí un bloque try-catch
        $this->manejador_conexion = new PDO($dsn,$this->usuario,$this->password,$opts);
        $this->manejador_conexion->exec('set names utf8');
    }
    /*public function getAllPokemons(){
        $resultado = $this->manejador_conexion->query('SELECT pokemons.id_pokemon, pokemons.nombre, tipos.nombre AS tipo, pokemons.url_imagen FROM pokemons INNER JOIN tipos ON pokemons.tipo = tipos.id_tipo')->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;       
    }*/
    public function getAllPokemons($params){
        if((isset($params['source'])&&($params['source']=='api'))){
            return $this->_getAllPokemonsFromAPI();
        }else{
            return $this->_getAllPokemonsFromDB();
        }
        
    }
    private function _getAllPokemonsFromAPI(){
        $ch = curl_init("https://pokeapi.co/api/v2/pokemon/1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/1");
        $resultado = curl_exec($ch);
        curl_close($ch);
    
        $resultado = json_decode($resultado,true);
        print_r($resultado);
    }
    private function _getAllPokemonsFromDB(){
        $resultado = $this->manejador_conexion->query('SELECT pokemons.id_pokemon, pokemons.nombre, tipos.nombre AS tipo, pokemons.url_imagen FROM pokemons INNER JOIN tipos ON pokemons.tipo = tipos.id_tipo')->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;       
    }
    public function getAllTipos(){
        $resultado = $this->manejador_conexion->query('SELECT * FROM tipos')->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function getPokemon($id){
        $resultado = $this->manejador_conexion->query('SELECT pokemons.id_pokemon, pokemons.nombre, tipos.nombre AS tipo, pokemons.url_imagen, pokemons.descripcion FROM pokemons INNER JOIN tipos ON pokemons.tipo = tipos.id_tipo WHERE pokemons.id_pokemon = \''.$id.'\'')->fetchAll(PDO::FETCH_ASSOC);
        
        return reset($resultado);
        
    }

    public function deletePokemon($id){
        return $this->manejador_conexion->query('DELETE from pokemons WHERE pokemons.id_pokemon = '.$id);
    }

    public function insertPokemon($params_pokemon){
        //return $this->manejador_conexion->query('INSERT INTO pokemons ('.$params_pokemon['poke_nombre'].', '.$param_pokemon['poke_tipo'].', '.$params_pokemon['poke_url'].', '.$params_pokemon['poke_desc']);
        $consulta = $this->manejador_conexion->prepare('INSERT INTO pokemons (nombre, tipo, url_imagen, descripcion) VALUES (:poke_nombre, :poke_tipo, :poke_img, :poke_desc)');
        return $consulta->execute(array(
            'poke_nombre' => $params_pokemon['poke_nombre'],
            'poke_tipo' => $params_pokemon['poke_tipo'],
            'poke_img' => $params_pokemon['poke_img'],
            'poke_desc' => $params_pokemon['poke_desc'],
        ));
  

    }
}