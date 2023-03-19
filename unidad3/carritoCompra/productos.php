<?php
require_once('./funciones.inc.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$params = array(
  'host' => 'localhost',
  'username' => 'root',
  'password' => '',
  'dbname' => 'ejtienda'
);
//si no se encuantra logado el cliente redirige a login
if (!isset($_SESSION['logadoCliente'])) {

  header("Location: ./login.php");
  exit();
  //comprueba la conexion 
} else {
  $conexion = conectar($params);
  $error = $conexion->connect_errno;

  if ($error != 0) {
    //Conexion correcta
    echo 'No se conectado correctamente con el servidor';
    exit();
  } else {

    //si no existe sesion cesta, crea e inizializa la cesta
    if (!isset($_SESSION['cesta'])) {

      $_SESSION['cesta'] = array();
    }
    //si se encuntra la sesion cesta y el post cesta añade articulo a la cesta
    if (isset($_SESSION['cesta']) && isset($_POST['cesta'])) {

      aniadirArticulo();
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="./css/estilo.css">
    </head>

    <body>
      <?php
      //imprimir articulos
      $consulta = 'SELECT * FROM producto ORDER BY familia asc , nombre_corto ASC';
      $resultado = $conexion->query($consulta); ?>
      <table>
        <tr>
          <td>Nombre</td>
          <td>Precio</td>
        </tr>

        <?php while ($producto = $resultado->fetch_array()) { ?>
          <tr>
            <td><?php echo $producto['nombre_corto'] ?></td>
            <!--<td><?php echo $producto['descripcion'] ?></td>-->
            <td><?php echo $producto['PVP'] ?>€</td>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
              <td id="sub"><input type="submit" value="Anadir a cesta" name="cesta[<?php echo $producto['cod'] ?>]"><input type="number" name="cantidadInsertado"></td>
            </form>
          </tr>
        <?php } ?>
      </table>
      <!--Formulario que manda al carrito-->
      <form action="./carrito.php" method="post">
        <input type="submit" value="Ir a carrito">
      </form>
  <?php
    //cerramos conexion de la base de datos
    $conexion->close();
  }
} ?>

    </body>

    </html>