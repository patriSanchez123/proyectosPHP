<?php

/**
 * Modelo donde controlamos todas las consultas tanto en la,
 * base de datos como la consultas a la API
 */
class ModeloPokemon
{
    //Variables para la conección de la BD donde están 
    //inicializadas en config
    protected $db_host = DB_HOST;
    protected $db_name = DB_NAME;
    protected $db_user = DB_USER;
    protected $db_password = DB_PASSWORD;
    protected $conection_handler;

    public function __construct()
    {
        //datos para la configuracion de la base de datos,
        // para cuando es muy concurrente las consultas de las base de datos
        $opts = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        //Conectamos a la base de datos con los atributos
        $dns = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
        $this->conection_handler = new PDO($dns, $this->db_user, $this->db_password);
        $this->conection_handler->exec('set names utf8');
    }

    private function _getPokemonBD($parametros)
    {

        $auxId = array();
        $tipos = array();
        $resultado = $this->conection_handler->query('SELECT pokemons.id, pokemons.numPokemon, pokemons.nombre, pokemons.url_imagen,pokemons.descripcion,pokemons.id,tipos.nombre as tipos,tipos.color FROM
        pokemons INNER JOIN tipoPokemon ON tipoPokemon.idPokemon=pokemons.id INNER JOIN tipos ON tipos.id_tipo=tipoPokemon.idTipo WHERE pokemons.id=' . $parametros['id'])->fetchAll(PDO::FETCH_ASSOC);


        //Si existe source=api imprime desde la pokeapi
        foreach ($resultado as $pokemon) {

            //si no existe el id en el auxId agrega un pokemon con su tipo    
            if (!in_array($pokemon['id'], $auxId)) {
                $auxId[] = $pokemon['id'];

                foreach ($resultado as $pokemonTipo) {

                    if ($pokemon['id'] == $pokemonTipo['id']) {

                        $tipos[] = array('tipo' => $pokemonTipo['tipos'], 'color' => $this->colorType($pokemonTipo['tipos']));
                    }
                }

                $datos[] = array(
                    'id' => $pokemon['id'],
                    'numPokemon' => $pokemon['numPokemon'],
                    'nombre' => $pokemon['nombre'],
                    'url_imagen' => $pokemon['url_imagen'],
                    'descripcion' => $pokemon['descripcion'],
                    'tipos' => $tipos
                );

                $tipos = array();
            }
        }

        return $datos[0];
    }

    /**
     * Función que comprueba si existe la id
     */
    function comprobarIdPokemon($parametros){
        
        return $this->conection_handler->query('SELECT * from pokemons WHERE pokemons.id='.$parametros['id'])->fetchAll(PDO::FETCH_ASSOC);
    }

    private function _getPokemonApi($parametros)
    {

        $tipos = array();
        //For para recorrer el curl, donde se le añade el indice en la dirección
        //web para que la itere

        //Inicia sesion con la pokeapi donde se va a iterar 
        $ch = curl_init("https://pokeapi.co/api/v2/pokemon/" . $parametros['id']);
        //configuracion del curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resultado = curl_exec($ch);

        //Decodifica el json que recibimos le la pokeapi
        $resultado = json_decode($resultado, true);

        //Guardamos los tipos
        foreach ($resultado['types'] as $tipo) {
            $tipos[] = array('tipo' => $tipo['type']['name'], 'color' => $this->colorType($tipo['type']['name']));
        }

        $pokemons[] = array(
            'id' => $resultado['id'],
            'nombre' => $resultado['forms'][0]['name'],
            'descripcion' => 'Pokémon que va contento por la pradera, comiendo lo que pilla y durmiendo su siesta en los árboles. No es amigable y va pegando mordiscos a todo el que lo toca.',
            'url_imagen' => $resultado['sprites']['other']['official-artwork']['front_default'],
            'get' => 'api',
            'tipos' => $tipos,

        );
        $tipos = array();


        //cerramos la consulta de curl

        return $pokemons[0];
    }
    /**
     * Función para mostrar los pokemon
     */
    public function getPokemon($parametros)
    {

        if (isset($parametros['source']) && $parametros['source'] == 'api') {

            return $this->_getPokemonApi($parametros);
        } else {

            return $this->_getPokemonBD($parametros);
        }
    }

    /**
     * Funcióm que muestra todos los pokemon de la base
     * de datos menos los tipos
     */
    private function _getAllPokemonsFromDB()
    {
        $auxId = array();
        $tipos = array();
        $resultado = $this->conection_handler->query('SELECT pokemons.id,pokemons.numPokemon, pokemons.nombre, pokemons.url_imagen,pokemons.descripcion,pokemons.id,tipos.nombre as tipos,tipos.color FROM
        pokemons INNER JOIN tipoPokemon ON tipoPokemon.idPokemon=pokemons.id INNER JOIN tipos ON tipos.id_tipo=tipoPokemon.idTipo ORDER BY numPokemon')->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultado as $pokemon) {

            //si no existe el id en el auxId agrega un pokemon con su tipo    
            if (!in_array($pokemon['id'], $auxId)) {
                $auxId[] = $pokemon['id'];


                foreach ($resultado as $pokemonTipo) {

                    if ($pokemon['id'] == $pokemonTipo['id']) {

                        $tipos[] = array('tipo' => $pokemonTipo['tipos'], 'color' => $this->colorType($pokemonTipo['tipos']));
                    }
                }
                $datos[] = array(
                    'id' => $pokemon['id'],
                    'numPokemon' => $pokemon['numPokemon'],
                    'nombre' => $pokemon['nombre'],
                    'url_imagen' => $pokemon['url_imagen'],
                    'descripcion' => $pokemon['descripcion'],
                    'tipos' => $tipos
                );

                $tipos = array();
            }
        }

        return $datos;
    }

    /**
     * Funcion que muestra todos los pokemon de pokeapi
     * Función antigua antes de paginar la pokeApi
     */
    private function _getAllPokemonsFromApi($parametros)
    {

        $min = 1;
        $max = 30;

        $tipos = array();
        //For para recorrer el curl, donde se le añade el indice en la dirección
        //web para que la iterepokemons.numPokemon
        for ($i = $min; $i < $max; $i++) {
            //Inicia sesion con la pokeapi donde se va a iterar 
            $ch = curl_init("https://pokeapi.co/api/v2/pokemon/" . $i);
            //configuracion del curl
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $resultado = curl_exec($ch);

            //Decodifica el json que recibimos le la pokeapi
            $resultado = json_decode($resultado, true);

            //Guardamos los tipos
            foreach ($resultado['types'] as $tipo) {
                $tipos[] = array('tipo' => $tipo['type']['name'], 'color' => $this->colorType($tipo['type']['name']));
            }

            $pokemons[] = array(
                'id' => $resultado['id'],
                'nombre' => $resultado['forms'][0]['name'],
                'url_imagen' => $resultado['sprites']['other']['official-artwork']['front_default'],
                'get' => 'api',
                'tipos' => $tipos,

            );
            $tipos = array();
        }
        //cerramos la consulta de curl
        curl_close($ch);
        return $pokemons;
    }

    public function _getAllPokemonsFromApiPaginado($parametros)
    {

        $cantidadPag = 30;
        $numPagina = 1;
        $tipos = array();
        $pokemons = array();

        //Si no existen el numero de pagina se crea la sesion y si existe se maneja la sesión para la paginación
        if (!isset($_SESSION['numPagina']) || empty($_SESSION['numPagina'])) {
            $_SESSION['numPagina'] = $numPagina;
            //Si existe la peticion ayax modifica la variable de sesion para poder paginar
        }
        if (isset($_GET["peticion"]) == "ayax") {

            $_SESSION['numPagina'] = $_SESSION['numPagina'] + 1;
        }
        //Si existe el post mostrar y cantidad no está vacia
        if (isset($_POST['mostrar']) && !empty($_POST['cantidad'])) {

            $_SESSION['cantidadPagina'] = $_POST['cantidad'];
            //Se maneja asi la sesión para que no pase a la siguiente pagina cuando se hace el post
            //para que muestre desde la misma página
            
                $_SESSION['numPagina']=$numPagina;;
            
        }
        if (!isset($_SESSION['cantidadPagina']) || empty($_SESSION['cantidadPagina'])) {
            $_SESSION['cantidadPagina'] = $cantidadPag;
        }

        //Formula para páginar
        $limit = $_SESSION['cantidadPagina'];
        $offset = ($_SESSION['numPagina'] - 1) * $_SESSION['cantidadPagina'];

        $ch = curl_init("https://pokeapi.co/api/v2/pokemon/?limit=" . $limit . "&offset=" . $offset);
        //configuracion del curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resultado = curl_exec($ch);

        //Decodifica el json que recibimos le la pokeapi
        $resultado = json_decode($resultado, true);
        curl_close($ch);

        foreach ($resultado['results'] as $resultados) {

            $ch = curl_init($resultados['url']);
            //configuracion del curl
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resultadoPokemon = curl_exec($ch);
            //Decodifica el json que recibimos le la pokeapi
            $resultadoPokemon = json_decode($resultadoPokemon, true);

            foreach ($resultadoPokemon['types'] as $tipo) {
                $tipos[] = array('tipo' => $tipo['type']['name'], 'color' => $this->colorType($tipo['type']['name']));
            }
            $pokemons[] = array(
                'id' => $resultadoPokemon['id'],
                'nombre' => $resultadoPokemon['forms'][0]['name'],
                'url_imagen' => $resultadoPokemon['sprites']['other']['official-artwork']['front_default'],
                'get' => 'api',
                'tipos' => $tipos,

            );

            $tipos = array();
        }

        //Si existe la petición de ayax se crea html para insertarlo en ayax en el caso contrario se le pasan
        //Los datos de la api directamente
        if (isset($_GET["peticion"]) == "ayax") {

            $envioDatos = $this->crearHTMLpokemon($pokemons);
        } else {
            $envioDatos = $pokemons;
        }
        return $envioDatos;
    }

    /**
     * Función que crea un html para pasar los datos a ayax para posteriormente
     * insertarlos en el mismo
     */
    function crearHTMLpokemon($parametros)
    {

        $html = "";
        foreach ($parametros as $valorPokemon) {
            $html .= '<div class="pokemon">';
            $html .= '<a href="./?controlador=pokemon&metodo=ver&id=' . $valorPokemon['id'] . '&source=api">';
            $html .= '<h2>' . $valorPokemon['nombre'] . '</h2>';
            $html .= '<img src="' . $valorPokemon['url_imagen'] . '" alt="foto">';
            $html .= '<div class=tipo>';
            foreach ($valorPokemon['tipos'] as $tipo) :
                $html .= '<p style="background:' . ($tipo['color'][0]['color']) . '">' . ($tipo['tipo']) . '</p>';
            endforeach;
            $html .= '</div>';
            $html .= '</a>';
            $html .= '<div id="opciones">';
            $html .= '<div id="aniadirBD">';
            $html .= '<a href=".?controlador=pokemon&metodo=insertarDesdeApi&id=' . $valorPokemon['id'] . '"><img src="http://localhost/unidad4/MVC/app/img/aniadir.png" alt="">';
            $html .= '<p>Añadir a BBDD</p>
                </a>
                </div>
                </div>
                </div>';
        }
        echo $html;
    }

    /***
     * Función que muestra los pokemon api o BD dependiendo de los parametros
     */
    public function getAllPokemons($parametros)
    {
        if ((isset($parametros['source']) && ($parametros['source'] == 'api'))) {

            return $this->_getAllPokemonsFromApiPaginado($parametros);
        } else {
            return $this->_getAllPokemonsFromDB();
        }
    }

    //Funcion que da los tipos en la base de datos
    //donde se filtra e
    public function getTypes()
    {

        $resultado = $this->conection_handler->query('SELECT tipoPokemon.idTipo,tipos.color,tipos.nombre,tipoPokemon.idPokemon 
    FROM tipos INNER JOIN tipoPokemon ON tipos.id_tipo = tipoPokemon.idTipo ORDER BY tipoPokemon.idPokemon')->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    }

    /**
     * Muestra los los tipos de los pokemon por el id en la base de datos 
     */
    public function getTypesId($id)
    {

        $resultado = $this->conection_handler->query('SELECT tipoPokemon.idTipo,tipos.color,tipos.nombre,tipoPokemon.idPokemon 
    FROM tipos INNER JOIN tipoPokemon ON tipos.id_tipo = tipoPokemon.idTipo WHERE tipoPokemon.idPokemon=' . $id)->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    }
    /**Función que muestra todos los tipos de pokemon que se utiliza para poner los colores en  la api */
    public function getAllTypes()
    {

        $resultado = $this->conection_handler->query('SELECT * FROM tipos')->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    /**
     * Función que inserta los pokemon en la BD
     */
    public function insertPokemon($params_pokemon)
    {
        //return $this->manejador_conexion->query('INSERT INTO pokemons ('.$params_pokemon['poke_nombre'].', '.$param_pokemon['poke_tipo'].', '.$params_pokemon['poke_url'].', '.$params_pokemon['poke_desc']);

        $consulta = $this->conection_handler->prepare('INSERT INTO pokemons (nombre, url_imagen, descripcion,numPokemon) VALUES (:poke_nombre, :url_img, :poke_desc, :numPokemon)');
        return $consulta->execute(array(
            'poke_nombre' => $params_pokemon['poke_nombre'],
            'url_img' => $params_pokemon['url_img'],
            'poke_desc' => $params_pokemon['poke_desc'],
            'numPokemon' => $params_pokemon['numPokemon'],
        ));
    }
    /**
     * Función que inserta los tipos de los pokemon en la BD
     */
    public function insertTipo($nombre, $params_pokemon)
    {
        //TODO tengo que insertar el id
        //Cuando se inserta un pokemon, nos hace falta una consulata

        //TODO en modifica do id_pokemon por id por si hay algun fallo
        $query = 'SELECT id FROM pokemons WHERE nombre=\'' . $nombre['poke_nombre'] . '\'AND id=(SELECT MAX(id) FROM pokemons)';
        $resultado = $this->conection_handler->query($query)->fetchAll(PDO::FETCH_ASSOC);


        $queryTipo = 'INSERT INTO tipoPokemon(idPokemon,idTipo) VALUES (:id_poke,:idTipo)';
        $insTipo = $this->conection_handler->prepare($queryTipo);

        return $insTipo->execute(array(
            'id_poke' => $resultado[0]['id'],
            'idTipo' => $params_pokemon
        ));
    }
    /**
     * Función que elimina pokemon en la base de datos
     */
    public function deletePokemon($id)
    {

        $query = 'DELETE FROM tipoPokemon WHERE  idPokemon=' . $id;
        $del = $this->conection_handler->prepare($query);
        $del->execute();

        $query = 'DELETE FROM pokemons WHERE  id=' . $id;
        $del = $this->conection_handler->prepare($query);
        $del->execute();
        return $del;
    }

    /**
     * Función que imprime el color del tipo con el parametro name del pokemon,
     * Función que se usa al insertar el pokemon, ya que al insertarlo no se conoce
     * el id del pokemon pero si el nombre por el post
     */
    public function colorType($name)
    {

        $query = 'SELECT color FROM tipos WHERE nombre=\'' . $name . '\'';
        $resultado = $this->conection_handler->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    /**
     * Función que da el id del pokemon insertandole como parametro el nombre
     * Función que se usa al insertar el pokemon, ya que al insertarlo no se conoce
     * el id del pokemon pero si el nombre por el post
     */
    public function idType($name)
    {

        $query = 'SELECT id_tipo FROM tipos WHERE nombre=\'' . $name . '\'';
        $resultado = $this->conection_handler->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    }

    /**
     * Función para insertar pokemon desde la poke api
     */
    function insertarApiaBBDD($parametros)
    {
        $desc = "Pokémon que va contento por la pradera, comiendo lo que pilla y durmiendo su siesta en los árboles. No es amigable y va pegando mordiscos a todo el que lo toca.";
        $tipo = array();
        $comprobarInsertado = false;
        $datos = $this->_getPokemonApi($parametros);
        $datospokemon = array(
            'poke_nombre' => $datos['nombre'],
            'url_img' => $datos['url_imagen'],
            'poke_desc' => $desc,
            'numPokemon' => $datos['id']
        );
        if ($this->insertPokemon($datospokemon)) {
            $comprobarInsertado = true;
        }

        foreach ($datos['tipos'] as $tipo) {
            $type = $this->idType($tipo['tipo']);
            $this->insertTipo($datospokemon, $type[0]['id_tipo']);
        }
        return $comprobarInsertado;
    }

    /**
     * Función para modificar un pokemon atravez de nuestra api
     */
    function modificarPokemon($parametros)
    {
        $query = $this->conection_handler->prepare('UPDATE pokemons SET numPokemon= :numPokemon, nombre= :nombre, url_imagen= :url_imagen, descripcion= :descripcion WHERE id= :id');
        return $query->execute(array(
            'id' => intval($parametros['id']),
            'nombre' => $parametros['nombre'],
            'numPokemon' => intval($parametros['numPokemon']),
            'descripcion' => $parametros['descripcion'],
            'url_imagen' => $parametros['url_imagen'],
        ));
    }

}
