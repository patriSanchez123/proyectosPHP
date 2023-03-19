<?php

Class Core{
  
    protected $controladorActual = 'pokemon';
    protected $metodoActual = 'listar';
    protected $parametros = [];

    //constructor
    public function __construct(){
        //Aquí sobreescribimos el controlador actual, el método y los parámetros que hay por defecto.

        //filtramos los get con filter_var($_GET['controlador'], FILTER_SANITIZE_URL) para que no tengamos ningun problema con la URL, 
        //si tuviera algun caracter especial que estropeara la URL
        if((isset($_GET['controlador']))&&(!empty($_GET['controlador']))){
          $this->controladorActual = filter_var($_GET['controlador'], FILTER_SANITIZE_URL);
        }
        if((isset($_GET['metodo']))&&(!empty($_GET['metodo']))){
            $this->metodoActual = filter_var($_GET['metodo'], FILTER_SANITIZE_URL);
        }
        //Guardamos el resto de gets en el array parametros
        $parametros = array_filter($_GET, fn($element)=>!in_array($element, ['controlador','metodo']), ARRAY_FILTER_USE_KEY);
        
        $this->parametros = filter_var_array($parametros, FILTER_SANITIZE_URL);
        
        //print_r(ucwords($this->controladorActual, '_'));
        /**
         * Comprobamos que exista el controlador, si existe el controlador se agrega el archivo
         * modificamos el nombre del controlador quitandole la _ y se le agrega una mayuscula despues
         * de cada _ y inicialimos el controlador
         * 
         */

            $nombre_controlador = str_replace('_','' ,ucwords($this->controladorActual,'_'));
            $this->controladorActual = new $nombre_controlador();

        
        /**
         * Se comprueba de que exista el método , en el controlador actual, si existe usamos el método
         * pasandole por parametros el array de parametros de el atributo de la clase, si no existe salta una exepción.
         */
        if(method_exists($this->controladorActual, $this->metodoActual)){
            
            $nombreMetodo = $this->metodoActual;

            $this->controladorActual->$nombreMetodo($this->parametros); //VAMOS POR AQUÍ, YA HEMOS LLAMADO AL CONTROLADOR Y AL MÉTODO QUE QUEREMOS. AHORA YA DENTRO DEL MÉTODO HABRÍA QUE OBTENER LOS DATOS DEL MODELO, Y SACARLOS POR LA VIEW. EN VIDE VAMOS EMPEZNDO EL 7
        }else{

            throw new Exception("No existe el metodo solicitado");
        }
    
    }

}