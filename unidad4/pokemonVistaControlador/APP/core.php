<?php 

class Core{

    protected $controladorActual='pokemon';
    protected $metodoActual='listar';
    protected $parametros = [];
//Creamos el contructor del core donde cojeremos los parametros correspondiente
    public function __construct(){

        //aqui sobrescribimos el controlador actual, el método y los parametros que 
        //hay por defecto
//comprobamos que exista el parametro controlador y esté lleno
        if(isset($_GET['controlador'])&& !empty($_GET['controlador'])){
            //funcion que retira los caracteres extraños para las URL filter_var
            $this->controladorActual=filter_var($_GET['controlador'],FILTER_SANITIZE_URL); 
//comprobamos que exista parametro método y que no esté vacio y retiramos los caracteres
        }if(isset($_GET['metodo'])&& !empty($_GET['metodo'])){
            $this->metodoActual = filter_var($_GET['metodo'],FILTER_SANITIZE_URL);

        }
        foreach($_GET as $clave => $valor){
            if($clave!='controlador'&& $clave!= 'metodo'){
            //TAMBIEN AÑADE
            //$this->parametros[]=array($clave=> filter_var($valor),FILTER_SANITIZE_URL);;
            $this->parametros+=array($clave=>filter_var($valor,FILTER_SANITIZE_URL) );
            //Si queremos filtar el array entero  lo hacemos con filter_var_array
        }
        }
    //Esta es otra manera de recoger los parametros de sobra
    //$parametros=array_fiLter($_GET,fn($element)=>!in_array($element,['controlador','metodo','parametro']),ARRAY_FILTER_USE_KEY);

    //Si existe el nombre del archivo  hace un require
    if(is_file('./APP/controllers/'.$this->controladorActual.'.php')){
    
        require_once('./APP/controllers/'.$this->controladorActual.'.php');
    //modificamos el nombre del controlador quitandole la '_' y poniendo la primera letra en mayuscula
        $nombreControlador= str_replace('_','',ucwords($this->controladorActual,'_'));
    //instanciamos la clase 
        $this->controladorActual = new $nombreControlador();
    }else{
        header("HTTP/1.1 404 Not Found"); 
    }
    if(method_exists($this->controladorActual ,$this->metodoActual)){
        $nombreMetodo=$this->metodoActual;
        $this->controladorActual->$nombreMetodo($this->parametros);
        }

    
    
}
    
        
}
