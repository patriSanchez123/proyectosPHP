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
<h2>Añadir Pokemon</h2>
<div id="formulario">
    <div id="texto">
<form action="./?controlador=pokemon&metodo=addPokemon" method="post" class="form" name="aniadir">
    <div class=divFormulario>
    <label for="nombre">Nombre:</label><input type="text" name="poke_nombre" id="nombre" class="texto" required><br>
    </div>
    <div class=divFormulario>
    <label for="numPokemon">Nº pokemon:</label><input type="number" name="numPokemon" id="numPokemon" class="texto" required><br>
    </div>
    <div class=divFormulario>
    <label for="imagen ">Ruta img</label><input type="url" name="url_img" id="image" class="texto" required><br>
    </div>
    <div class=divFormulario>
    <label for="desc ">Descripcion:</label><input type="text" name="poke_desc" id="desc" required><br>
    </div>
    </div>
        <legend>Tipos pokemon</legend>
        <div class=tiposFormulario>
        <?php foreach($datos as $tipo):?>
        <div class=divFormulario>
        <input type="checkbox" name="poke_tipo[<?php echo $tipo['id_tipo'] ?>]" id="<?php echo $tipo['id_tipo'] ?>"> <label for="<?php echo $tipo['id_tipo'] ?>"> <?php echo $tipo['nombre'] ?></label>
        </div>
        <?php endforeach; ?>
        </div>
   
    <input type="submit" name="add_pokemon" value="Enviar ">
</form>
</div>

<?php include_once("./app/vista/inc/footer.tpl.php")?>
