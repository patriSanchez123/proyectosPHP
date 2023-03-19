<?php

class Pokemon
{

  private $mensajes_usuarios;

  public function __construct()
  {

    if (isset($_SESSION['mensajes_usuario'])) {
      $this->mensajes_usuarios = $_SESSION['mensajes_usuario'];
    } else {
      $this->mensajes_usuarios = "";
    }
  }
  /**
   * Función que lista los pokemon desde la base de datos
   */
  public function listar($parametros)
  {
    $mensajes_usuarios = $this->mensajes_usuarios;
    $datos = array();
    $modelo_pokemon = new ModeloPokemon();
    $datos = $modelo_pokemon->getAllPokemons($parametros);

    if (is_file(RUTA_APP . '/vista/listar_pokemon.tpl.php')) {

      require_once(RUTA_APP . '/vista/listar_pokemon.tpl.php');
      
      $_SESSION['mensajes_usuario'] = "";
    } else {
      throw new Exception("No se  encuentra la vista solicitada");
    }
  }

  /**
   * Funcion que visualiza un pokemon por su id desde
   * la base de datos
   */
  public function ver($parametros)
  {
    $mensajes_usuarios = $this->mensajes_usuarios;
    $datos = array();
    $id = $parametros['id'];
    //Comprueba si el parametros es un entero
    if (ctype_digit($id)) {
      $modelo_pokemon = new ModeloPokemon();
      $datos = $modelo_pokemon->getPokemon($parametros);
      

      if (is_file(RUTA_APP . '/vista/ver_pokemon.tpl.php')) {
        require_once(RUTA_APP . '/vista/ver_pokemon.tpl.php');
        $_SESSION['mensajes_usuario'] = "";
      } else {
        throw new Exception("No se  encuentra la vista solicitada");
      }
    } else {
      echo 'No es un int';
    }
    
  }

  /**
   * Función que elimina pokemon de la base de datos
   */
  public function eliminar($parametros)
  {

    $id = $parametros['id'];
//Comprobamos que el id es un entero
    if (ctype_digit($id)) {
      $modelo_pokemon = new ModeloPokemon();
      if ($modelo_pokemon->deletePokemon($id)) {
        $this->mensajes_usuarios = 'Pokemon bien borrado';
      } else {
        $this->mensajes_usuarios = 'Error al borrar el pokemon';
      }
      $_SESSION['mensajes_usuario'] = $this->mensajes_usuarios;
    }
    //Redireciona a listar los pokemon desde la BD
    header('Location:./?controlador=pokemon&metodo=listar');
  }

  /**
   * Función que añade pokemon en la BD
   */
  public function addPokemon()
  {

    $mensajes_usuarios = $this->mensajes_usuarios;
    $modelo = new ModeloPokemon();
    $datos = array();
    //Si no existe el POST imprime la lista de pokemon de la BD
    if (!isset($_POST['add_pokemon'])) {

      if (is_file("./app/vista/formulario_add_pokemon.tpl.php")) {
        //iniciamos la variable de datos
        $datos = $modelo->getAllTypes();
        require_once("./app/vista/formulario_add_pokemon.tpl.php");
      } else {
        throw new Exception("No se  encuentra la vista solicitada");
      }
      //Si existe el POST  insertamos el pokemon
    } else {
      //inicializamos la variable con el POST
     $parametros_pokemon = $_POST;
      //Guardamos la clave de los tipos en una variable
      $tipos_pokemon = array_keys($parametros_pokemon['poke_tipo']);
      // Si el insert es TRUE añadimos los tipos a la BD
      if ($modelo->insertPokemon($parametros_pokemon)) {
        $_SESSION['mensajes_usuario'] = 'Pokemon se ha insertado adecuadamente';
        $this->mensajes_usuarios = $_SESSION['mensajes_usuario'];
        foreach ($tipos_pokemon as $tipo) {
          $tipo = intval($tipo);
          if ($modelo->insertTipo($parametros_pokemon, $tipo)) {
            //TODO tengo que optimizarlo en la clase mensaje
            
            echo 'se ha insertado el tipo correctamente';
          } else {
            echo 'No se ha insertado el tipo correctamente';
          }
        }
        //redirecionamos a listar
        header('Location: ./?controlador=pokemon&metodo=listar');
      } else {
        $_SESSION['mensajes_usuario'] = 'No se ha podido insertar el pokemon';
        $this->mensajes_usuarios = $_SESSION['mensajes_usuario'];
        header('Location: ./?controlador=pokemon&metodo=addPokemon');
      }
  }
}

  function insertarDesdeApi($parametros){
    $mensajes_usuarios = $this->mensajes_usuarios;

    $modelo= new ModeloPokemon();
    if($modelo->insertarApiaBBDD($parametros)){
      $_SESSION['mensajes_usuario'] = 'Pokemon se ha insertado adecuadamente';
      $this->mensajes_usuarios = $_SESSION['mensajes_usuario'];
    }else{
      $this->mensajes_usuarios = $_SESSION['mensajes_usuario'];
      $_SESSION['mensajes_usuario'] = 'El pokemon no se ha insertado correctamente';
    }
    header('Location: ./?controlador=pokemon&metodo=listar&source=api');
  }
function paginarPokemons($parametros){
 
  $modelo=new modeloPokemon($parametros);

 return $modelo->getAllPokemons($parametros);

}

function veInstrucionesMiApi($parametros){

  $mensajes_usuarios = $this->mensajes_usuarios;
    if (is_file("./app/vista/miApi.tpl.php")) {
      
      require_once("./app/vista/miApi.tpl.php");
    } else {
      throw new Exception("No se  encuentra la vista solicitada");
    }

}

function modificarPokemonBD($parametros){
  $mensajes_usuarios = $this->mensajes_usuarios;
  if (!isset($_POST['modificar'])) {
    //creo una sesion para guardar la id del pokemon que vamos a modificar
    $_SESSION['id']=$parametros['id'];

    if (is_file("./app/vista/modificarPokemon.tpl.php")) {
      
      require_once("./app/vista/modificarPokemon.tpl.php");
      
    } else {
      throw new Exception("No se  encuentra la vista solicitada");
    }
    //Si existe el POST  insertamos el pokemon
  } else {
  $parametros_pokemon = $_POST;
  $parametros_pokemon+=array('id'=>$_SESSION['id']);
  print_r($parametros_pokemon);
  
  $modelo=new modeloPokemon();

    if($modelo->modificarPokemon($parametros_pokemon)){
      $_SESSION['mensajes_usuario'] = 'Pokemon modificado correctamente';
    }else{
      $_SESSION['mensajes_usuario'] = 'No se ha podido modidicar el pokemon';
    }

    header('Location:./?controlador=pokemon&metodo=listar');
  

  
}
}
}



