<?php
class controladorResapi
{

    public function procesar($parametros)
    {
        //Se comprueban que existen los parametros
        if (isset($parametros['path'])) {
            $modelo = new ModeloPokemon();
            //Separamos los parametros path para poder manejarlos, se utiliza a partir del el indice 1 ya que el 0 es un valor vacio
            $separarRuta = explode("/", $parametros['path']);
            $arrayRuta = array('metodo' => $separarRuta[1]);
            //Si existe el metodo get comprobamos, las rutas si existen
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                
                if ((isset($separarRuta[1]) && $separarRuta[1] == 'pokemon') && !isset($separarRuta[2])) {
                header('Content-Type: application/json; charset=utf-8');
                    echo (json_encode($modelo->getAllPokemons($parametros)));
                }

                elseif ((isset($separarRuta[1]) && $separarRuta[1] == 'pokemon') && (isset($separarRuta[2]) && is_numeric($separarRuta[2]))) {
                header('Content-Type: application/json; charset=utf-8');
                    $id = intval($separarRuta[2]);
                    $arrayRuta[] = array('id' => $id);
                    echo (json_encode($modelo->getPokemon($arrayRuta[0])));
                }
                elseif((isset($separarRuta[1]) && $separarRuta[1] == 'tipos')){
                    header('Content-Type: application/json; charset=utf-8');
                    echo (json_encode($modelo->getAllTypes()));
                }
            }
            //Si existe el metodo post comprobamos la ruta y insertamos el pokemon en la base de datos
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ((isset($separarRuta[1]) && $separarRuta[1] == 'pokemon') && (isset($separarRuta[2]) && $separarRuta[2] == 'insertar')) {
                    
                    $datos = $_POST;
                    //Si se inserta pokemon correctamente insertamos los datos y mandamos la cabecera,si los tipos dan fallo solo se inserta el
                    //pokemon
                    if($modelo->insertPokemon($datos)){
                        header("HTTP/1.1 200 OK");
                    
                    $tipo1 = intval($datos['tipo1']);
                    if($datos['tipo1'] < 21 && $datos['tipo1'] > 0){
                        $modelo->insertTipo($datos, $tipo1);
                    }
                    //si existe el tipo2 inserta de nuevo otro tipo
                    if (isset($datos['tipo2'])) {
                        $tipo1 = intval($datos['tipo2']);
                        if($datos['tipo1'] < 21 && $datos['tipo1'] > 0){
                        $modelo->insertTipo($datos, $datos['tipo2']);
                    }
                    }
                    
                }else{
                    header("HTTP/1.1 404 Not Found");
                }
                 
            }
        }
        //Si existe el metodo delete comprobamos los parametros y borramos el pokemon
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                if ((isset($separarRuta[1]) && $separarRuta[1] == 'pokemon') && (isset($separarRuta[2]) && $separarRuta[2] == 'borrar' && is_numeric($separarRuta[3]))) {

                    if($modelo->deletePokemon($separarRuta[3])){
                        header("HTTP/1.1 200 OK");
                    }else{
                        header("HTTP/1.1 404 Not Found");
                    }
                }
                
            }
            //Si existe el metodo PUT comprobamos la ruta si es correcta y si existen datos en el put, si es correcto todo
            //decodificamos los datos Json y lo añadimos a modificar pokemon
            if($_SERVER['REQUEST_METHOD'] === 'PUT'){

                if((isset($separarRuta[1]) && $separarRuta[1] == 'pokemon') && (isset($separarRuta[2]) && $separarRuta[2]=="actualizar")){
                if(!empty(file_get_contents("php://input"))){

                    $datosPUT = json_decode(file_get_contents("php://input"),true);
                    if($modelo->modificarPokemon($datosPUT)){
                        header("HTTP/1.1 200 OK");
                    }
                }
            

                }
            }
        } else {

            header("HTTP/1.0 404 Not Found");
        }
    }

}
