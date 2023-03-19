<?php

class ControladorPokemon{

  private $mensajes_usuario;

    public function __construct(){
        //echo 'controlador pokemon cargado';
        if(isset($_SESSION['mensajes_usuario'])){
          $this->mensajes_usuario = $_SESSION['mensajes_usuario'];
        }else{
          $this->mensajes_usuario = '';
        }
    }
    public function listar($params){
        $mensajes_usuario = $this->mensajes_usuario;
        $modelo_pokemon = new ModeloPokemon();
        $datos = $modelo_pokemon->getAllPokemons($params);
      
      
      if(is_file("./app/vistas/pokemon/listado_pokemons.tpl.php")){
        require_once('./app/vistas/pokemon/listado_pokemons.tpl.php');
        $_SESSION['mensajes_usuario'] = '';
      }else{
        throw new Exception('Vista no disponible');
      }
    }
    public function ver($params){
      $mensajes_usuario = $this->mensaje_usuario;
      $id= $params['id'];
      //Tenemos que asegurar que $id es un entero. En cualquier otro caso podría haber problemas de seguridad
      if(ctype_digit($id)){
          $modelo_pokemon = new ModeloPokemon();
          $datos = $modelo_pokemon->getPokemon($id);
        

        if(is_file("./app/vistas/pokemon/info_pokemon.tpl.php")){
          require_once('./app/vistas/pokemon/info_pokemon.tpl.php');
          $_SESSION['mensajes_usuario'] = '';

        }else{
          throw new Exception('Vista no disponible');
        }
      }else{
        throw new Exception('El parámetro no es adecuado');
      }
    }
    public function eliminar($params){
      $id= $params['id'];
      //Tenemos que asegurar que $id es un entero. En cualquier otro caso podría haber problemas de seguridad
      if(ctype_digit($id)){
          $modelo_pokemon = new ModeloPokemon();
          if($modelo_pokemon->deletePokemon($id)){
            //Aquí entra solo si se ha borrado un pokemon
            //Mostramos un mensaje de pokemon borrado satisfactoriamente
            $this->mensajes_usuario = 'Pokemon bien borrado';

          }else{
            //Aquí entra si no se ha borrado ningún pokemon porque no se encontró el id
            $this->mensajes_usuario = 'No se encontró el id del pokemon';
            
          }
          $_SESSION['mensajes_usuario'] = $this->mensajes_usuario;
      }
      header('Location: ./?controlador=pokemon&metodo=listar');
      
    }

    public function addPokemon(){
      $modelo = new ModeloPokemon();
      if(!isset($_POST['add_pokemon'])){
       //Aquí entra la primera vez, o cuando no hay datos en $_POST['add_pokemon']
       if(is_file("./app/vistas/pokemon/formulario_add_pokemon.tpl.php")){
        $datos = array();
      
        $datos['tipos'] = $modelo->getAllTipos();
        
        require_once('./app/vistas/pokemon/formulario_add_pokemon.tpl.php');
       
        }else{
          throw new Exception('Vista no disponible');
        }
      }else{
        //Aquí entra si el usuario ha pulsado el botón add_pokemon del formulario
        $parametros_pokemon = $_POST;
        $parametros_pokemon['poke_tipo'] = reset(array_keys($parametros_pokemon['poke_tipo']));
        if($modelo->insertPokemon($parametros_pokemon)){
          $_SESSION['mensajes_usuario'] = 'Pokemon insertado adecuadamente';
          $this->mensajes_usuario = $_SESSION['mensajes_usuario'];
          header('Location: ./?controlador=pokemon&metodo=listar');
        }else{
          $_SESSION['mensajes_usuario'] = 'Se ha petao';
          $this->mensajes_usuario = $_SESSION['mensajes_usuario'];
          header('Location: ./?controlador=pokemon&metodo=addPokemon');
        }; 
      }
    }

    
}