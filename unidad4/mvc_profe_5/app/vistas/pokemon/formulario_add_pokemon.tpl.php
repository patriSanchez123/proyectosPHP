<?php include_once('./app/vistas/inc/header.tpl.php'); ?>
<h2>Introduce los datos de tu bicho</h2>
<form method="post" action="./?controlador=pokemon&metodo=addPokemon">
    <p><label for="poke_nombre">Nombre</label> <input id="poke_nombre" type="text" name="poke_nombre"></p>
    <p><label for="poke_desc">Descripción</label> <input id="poke_desc" type="text" name="poke_desc"></p>
    <p><label for="poke_img">Imagen</label> <input id="poke_img" type="url" name="poke_img"></p>
    <p><strong>Tipos</strong></p>
    <?php foreach($datos['tipos'] as $tipo): ?>
    <p><label for="poke_tipo[<?php echo $tipo['id_tipo']; ?>]"><?php echo ucwords($tipo['nombre']) ;?></label> <input id="poke_tipo[<?php echo $tipo['id_tipo']; ?>]" 
    type="checkbox" name="poke_tipo[<?php echo $tipo['id_tipo']; ?>]"></p>
    <?php endforeach; ?>
    <p><input type="submit" name="add_pokemon" value="Enviar"></p>
</form>
<p><a href="./">Volver</a></p>
<?php include_once('./app/vistas/inc/footer.tpl.php'); ?>