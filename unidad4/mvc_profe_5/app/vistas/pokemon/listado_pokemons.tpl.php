<?php include_once('./app/vistas/inc/header.tpl.php'); ?>
<h1>Listado de pokemons</h1>
<table>
    <thead>
        <th>Foto</th>    
        <th>Nombre</th>
        <th>Tipo</th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach($datos as $pokemon => $datos_pokemon): ?> 
            <tr>
                <td><img width="96" height="96" src="<?php echo $datos_pokemon['url_imagen']; ?>" ></td>
                <td><a href="./?controlador=pokemon&metodo=ver&id=<?php echo $datos_pokemon['id_pokemon']; ?>"><?php echo ucwords($datos_pokemon['nombre']); ?></a></td>
                <td><?php echo ucwords($datos_pokemon['tipo']); ?></td>
                <td><a href="?controlador=pokemon&metodo=eliminar&id=<?php echo $datos_pokemon['id_pokemon']; ?>">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p><a href="./?controlador=pokemon&metodo=addPokemon">Añadir pokemon</a></p>
<?php include_once('./app/vistas/inc/footer.tpl.php'); ?>