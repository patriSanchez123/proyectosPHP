<?php 
include_once("./app/vista/inc/header.tpl.php")?>
<header>
<img src="https://www.dafont.com/forum/attach/orig/6/7/673025.png?1" alt="pokemon" id="fotoPokemon">
    <nav>
    <a href="./?controlador=pokemon&metodo=listar&source=api" id="pokeapi">Pokeapi</a>
    <a href="./?controlador=pokemon&metodo=listar" id="db">Base de datos</a>
    <a href="#" id="miApi">Nuestra pokeapi</a>
</nav>
</header>
<h2>Modificar pokemon</h2>
<div id="formulario">
    <div id="texto">
<form action="./?controlador=pokemon&metodo=modificarPokemonBD" method="post" class="form" name="modificar">
    <div class=divFormulario>
    <label for="nombre">Nombre:</label><input type="text" name="nombre" id="nombre" class="texto" required><br>
    </div>
    <div class=divFormulario>
    <label for="numPokemon">Nº pokemon:</label><input type="number" name="numPokemon" id="numPokemon" class="texto" required><br>
    </div>
    <div class=divFormulario>
    <label for="imagen ">Ruta img</label><input type="url" name="url_imagen" id="image" class="texto" required><br>
    </div>
    <div class=divFormulario>
    <label for="desc ">Descripcion:</label><input type="text" name="descripcion" id="desc" required><br>
    </div>
    </div>
   
    <input type="submit" name="modificar" value="Enviar ">
</form>
</div>

<?php include_once("./app/vista/inc/footer.tpl.php")?>