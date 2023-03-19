<?php include_once("./app/vista/inc/header.tpl.php") ?>

<header>
<img src="https://www.dafont.com/forum/attach/orig/6/7/673025.png?1" alt="pokemon" id="fotoPokemon">
<?php if (isset($datos['get'])) {?>
    <nav>
    <a href="./?controlador=pokemon&metodo=listar&source=api" id="pokeapi" class="marcadoBlanco">Pokeapi</a>
    <a href="./?controlador=pokemon&metodo=listar" id="db">Base de datos</a>
    <a href="?controlador=pokemon&metodo=veInstrucionesMiApi" id="miApi">Nuestra pokeapi</a>
</nav>
<?php }else{?>
    <nav>
    <a href="./?controlador=pokemon&metodo=listar&source=api" id="pokeapi" >Pokeapi</a>
    <a href="./?controlador=pokemon&metodo=listar" id="db" class="marcadoBlanco">Base de datos</a>
    <a href="?controlador=pokemon&metodo=veInstrucionesMiApi" id="miApi">Nuestra pokeapi</a>
</nav>
    <?php }?>
</header>
<main>
    <h1>Descripción</h1>
    <div id="cuerpoPokemonVer">
        <div id="pokemonVer">
        <!--Este if donde se le añade distinta variable, ya que el numero del pokemon de la api es la id y la id de la
        la base de datos es un elemento unico "NO ES EL NUMERO DEL POKEMON"-->
            <h2><?php echo $datos['nombre']; ?></h2>
            <?php if (isset($datos['get'])) { ?>
                <p>Nº<?php echo $datos['id']; ?></p>
            <?php } else { ?>
                <p>Nº<?php echo $datos['numPokemon']; ?></p>
            <?php } ?>
            <img src="<?php echo $datos['url_imagen'] ?>" id="imagenPokemonVer">
            <div id="tiposVer">
            <!--Iteramos el tipo para mostarlo con sus colores correspondientes-->
                <?php foreach ($datos['tipos'] as $tipo) : ?>
                    <p style="background: <?php echo ($tipo['color'][0]['color']) ?>"><?php echo ($tipo['tipo']) ?></p>
                <?php endforeach ?>
            </div>
            <!--Si no existe la variable get inserta la imagen de la papelera-->
            <?php if (!isset($datos['get'])) : ?>
                <div id="opciones">
                    <a href="./?controlador=pokemon&metodo=eliminar&id=<?php echo $valorPokemon['id']; ?>"><img src="http://localhost/unidad4/MVC/app/img/papelera.ico" alt="Eliminar"></a>
                </div>
            <?php endif; ?>
        </div>
        <p><?php echo $datos['descripcion'] ?></p>
    </div>
</main>
<?php include_once("./app/vista/inc/footer.tpl.php") ?>