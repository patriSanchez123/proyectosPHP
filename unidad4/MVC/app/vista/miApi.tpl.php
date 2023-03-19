<?php
include_once("./app/vista/inc/header.tpl.php") ?>

<div id="cuerpoPokemon">
<header>
<img src="https://www.dafont.com/forum/attach/orig/6/7/673025.png?1" alt="pokemon" id="fotoPokemon">

    <nav>
    <a href="./?controlador=pokemon&metodo=listar&source=api" id="pokeapi">Pokeapi</a>
    <a href="./?controlador=pokemon&metodo=listar" id="db">Base de datos</a>
    <a href="?controlador=pokemon&metodo=veInstrucionesMiApi" id="miApi" class="marcadoBlanco" >Nuestra pokeapi</a>
</nav>

</header>
   <main id="instrucionesApi">
   <h2>Instruciones</h2>
    <article id="textoInstruciones">
        
        <p>Para que se funcional la api hay que añadir valores que existan en la base de datos, en los apartados siguientes aparecen ejemplos
            de las peticiones en la ApiPatri,los datos para las consultas GET son de tipo json para el resto de consultas son header 200 para datos correctos
            header 400 para datos incorrectos.
        </p>
        <li>Las ides requeridas tienen que existir previamente en la base de datos se pueden consultar en el apartado Bases de datos arriba
         de la foto del pokemon</li>
         <li>Los tipos de pokemon se añaden a traves de las ides para saber el tipo de pokemon consulte la api con los tipos, no se pueden añadir más
            de dos tipos en los pokemon.Solo se pueden añadir tipos del 1 al 20 si no es asi solo se insertará el pokemon sin los tipos.
         </li>
        <hr>
    </article>
    <article class="instrucciones">
        <h2>Petición GET consultar todos los pokemons Json Pokemons</h2>
        <p>curl -X GET http://localhost/unidad4/MVC/?controlador=controlador_resapi'&'metodo=procesar'&'path=/pokemon</p>
        <hr>
    </article>
    
    <article class="instrucciones">
        <h2> Petición GET consultar un pokemon Json por su id</h2>
        <p>curl -X GET http://localhost/unidad4/MVC/?controlador=controlador_resapi'&'metodo=procesar'&'path=/pokemon/89</p>
        <hr>
    </article>

     <article class="instrucciones">
        <h2>Petición GET consultar todos los tipos</h2>
        <p>curl -X GET http://localhost/unidad4/MVC/?controlador=controlador_resapi'&'metodo=procesar'&'path=/tipos</p>
        <hr>
    </article>
    
    <article class="instrucciones">
        <h2>Petición DELETE borrar pokemon por su id</h2>
        <p>curl -X "DELETE" http://localhost/unidad4/MVC/?controlador=controlador_resapi'&'metodo=procesar'&'path=/pokemon/borrar/85</p>
        <hr>
    </article>
    
    <article class="instrucciones">
        <h2>Petición POST insertar pokemon</h2>
        <p>curl -d 'poke_nombre=bestia & url_img=https://d500.epimg.net/cincodias/imagenes/2016/07/26/album/1469523290_063392_1469524739_album_normal.jpg & poke_desc=entra & numPokemon=1 & tipo1=2 & tipo2=3' -X POST http://localhost/unidad4/MVC/?controlador=controlador_resapi'&'metodo=procesar'&'path=/pokemon/insertar</p>
        <hr>
    </article>
   
    <article class="instrucciones">
        <h2>Petición PUT modificar pokemon</h2>
        <p>curl -d '{"id":5 ,"nombre":"Aceituna","numPokemon":1,"descripcion":"Pokemon que se combierte en aceite","url_imagen":"https://e00-marca.uecdn.es/assets/multimedia/imagenes/2022/06/01/16540932961450.png" }' -X "PUT" http://localhost/unidad4/MVC/?controlador=controlador_resapi'&'metodo=procesar'&'path=/pokemon/actualizar</p>
        <hr>
    </article>

   </main>
   

<?php include_once("./app/vista/inc/footer.tpl.php") ?>