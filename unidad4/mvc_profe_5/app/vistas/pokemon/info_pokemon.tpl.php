<?php include_once('./app/vistas/inc/header.tpl.php'); ?>
<h1>Detalles del pokemon <?php echo $datos['nombre']; ?></h1>
<h2>El pokemon es de tipo <?php echo $datos['tipo']; ?></h2>
<p><img src="<?php echo $datos['url_imagen']; ?>" > <?php echo $datos['descripcion']; ?></p>
<p><a href="./">Volver</a></p>
<?php include_once('./app/vistas/inc/footer.tpl.php'); ?>