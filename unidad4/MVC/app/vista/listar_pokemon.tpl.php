<?php
include_once("./app/vista/inc/header.tpl.php") ?>

<div id="cuerpoPokemon">
<header>
<img src="https://www.dafont.com/forum/attach/orig/6/7/673025.png?1" alt="pokemon" id="fotoPokemon">
<!--Añado diferentes navegadores para poder marcar en el navegador en que parte nos encontramos del menú-->
<?php if (isset($datos[0]['get'])) {?>
    <nav>
    <a href="./?controlador=pokemon&metodo=listar&source=api" id="pokeapi" class="marcadoBlanco">Pokeapi</a>
    <a href="./?controlador=pokemon&metodo=listar" id="db">Base de datos</a>
    <a href="./?controlador=pokemon&metodo=veInstrucionesMiApi" id="miApi">Nuestra pokeapi</a>
</nav>
<?php }else{?>
    <nav>
    <a href="./?controlador=pokemon&metodo=listar&source=api" id="pokeapi" >Pokeapi</a>
    <a href="./?controlador=pokemon&metodo=listar" id="db" class="marcadoBlanco">Base de datos</a>
    <a href="http://localhost/unidad4/MVC/?controlador=pokemon&metodo=veInstrucionesMiApi" id="miApi">Nuestra pokeapi</a>
</nav>
    <?php }?>
</header>
   
    <div id="botonesVer">
            <!--Si existe imprime el formulario para mostrar los pokemon desde hasta y el boton ver BD-->
        <?php  if (isset($datos[0]['get'])) { ?>
            <div id="opcionesApiListar">
                <form action="./?controlador=pokemon&metodo=listar&source=api" method="post">
                    <div id="inputApi">
                        <label for="cantidad">Cantidad páginas: </label><input type="number" id="cantidad" name="cantidad">
                        <input type="submit" value="Mostrar" name="mostrar" class="mostrar">
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
    <!--Si no existe la variable get imprime el boton añadir en la base de datos-->
    <?php if (!isset($datos[0]['get'])) : ?>
        <div id="aniadir">
            <a href=".?controlador=pokemon&metodo=addPokemon"><img src="http://localhost/unidad4/MVC/app/img/aniadir.png" alt=""></a>
            <p>Añadir pokemon</p>
        </div>
    <?php endif; ?>
    <main>
        <!--En vez de usar la llave para cerrar el foreach se usa sos puntos-->
        <div id="pokemons">

        <?php foreach ($datos as $valorPokemon):?>

                <div class="pokemon">
                    <!--Si en los datos existe la variable get lista lel modelo de la api-->
                    <?php if (isset($valorPokemon['get']) && ($valorPokemon['get'] = 'api')) { ?>
                        <a href="./?controlador=pokemon&metodo=ver&id=<?php echo $valorPokemon['id']; ?>&source=api">
                        <?php } else { ?>
                        <!--Si  existe  la base de datos-->
                            <a href="./?controlador=pokemon&metodo=ver&id=<?php echo $valorPokemon['id']; ?>">
                            <p id="ides"><?php echo 'Id :'. $valorPokemon['id']; ?></p>
                            <?php } ?>
                            <h2><?php echo $valorPokemon['nombre']; ?></h2>
                            <img src="<?php echo $valorPokemon['url_imagen'] ?>">
                            <div class=tipo>
                                <?php foreach ($valorPokemon['tipos'] as $tipo): ?>
                                    <!--El array es un poco raro pero funciona bien-->
                                    <p style="background: <?php echo ($tipo['color'][0]['color']) ?>"><?php echo ($tipo['tipo']) ?></p>
                                <?php endforeach ?>
                            </div>
                            </a>
                            <div id="opciones">
                            <!--Si existe la varible get imprime el boton añadir a la base de datos--->
                                <?php if (isset($valorPokemon['get']) && ($valorPokemon['get'] = 'api')) { ?>
                                    <div id="aniadirBD">
                                        <a href=".?controlador=pokemon&metodo=insertarDesdeApi&id=<?php echo $valorPokemon['id'] ?>"><img src="http://localhost/unidad4/MVC/app/img/aniadir.png" alt="">
                                            <p>Añadir a BBDD</p>
                                        </a>
                                    </div>
                                <!--Si no existe imprime borrar de la base de datos e editar "EDITAR ESTA DE ADORNO"-->
                                <?php } else { ?>
                                    <a href="./?controlador=pokemon&metodo=eliminar&id=<?php echo $valorPokemon['id']; ?>"><img src="http://localhost/unidad4/MVC/app/img/papelera.ico" alt="Eliminar"></a>
                                    <a href="./?controlador=pokemon&metodo=modificarPokemonBD&id=<?php echo $valorPokemon['id']; ?>"><img src="http://localhost/unidad4/MVC/app/img/lapiz.ico" alt="Editar"></a>
                                <?php }?>
                            </div>
                </div>

            <?php endforeach ?>
            <!---TODO insertar aqui desde ayax  -->
        </div>
        
        <div id="botonesFinales">
        <?php if (isset($valorPokemon['get']) && ($valorPokemon['get'] = 'api')):?>
            <a href="#" class="boton" id="siguiente">Siguiente</a>
            <?php endif?>
        </div>
       
        
</div>

    </main>
<?php include_once("./app/vista/inc/footer.tpl.php") ?>