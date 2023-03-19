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
$arrayAuxRepetido = array();
$maximoProducto = 0;
$precioTotalUnidades = 0;
//si existe cerrar sesión destruye la sesión y nos manda a login
if (isset($_POST['cerrarSesion'])) {
    session_destroy();
    header("Location: ./login.php");
}
//Si no existe cliente redirige a login
if (!isset($_SESSION['logadoCliente'])) {
    header("Location: ./login.php");
    exit();
} else {
    //si está el cliente loguedado sigue con el código
    $conexion = conectar($params);
    $error = $conexion->connect_errno;
    //comprueba que la conexion est´`e correcta
    if ($error != 0) {

        echo "<p>Ha ocurrido un error al conectarse a la base de datos</p>";
        exit();
        //si la conexión es correcta continua
    } else {
        //Si existe eliminar y cesta elimina en numero correspondiente de elementos
        if (isset($_SESSION['cesta']) && isset($_POST['eliminar'])) {
            eliminarArticulo();
        }


?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="./css/estilo.css">
            <title>Carrito</title>

        </head>

        <body>
            <h1>Cesta</h1>
            <?php
            //si existe cesta imprime la tabla con los productos seleccionados
            if (isset($_SESSION['cesta'])) { ?>

                <table>
                    <tr>
                        <td>Nombre del Articulo</td>
                        <td>Precio Unidad</td>
                        <td>Numero de unidades</td>
                        <td>Precio total Unidades</td>
                        <td></td>
                    </tr>
                    <?php foreach ($_SESSION['cesta'] as $clave => $valor) {
                        //si el valor no se encuentra en array auxiliar se añade al array
                        if (!in_array($valor, $arrayAuxRepetido)) {
                            array_push($arrayAuxRepetido, $valor);
                            //contamos los productos que se encuentran en nuestra cesta para no poder eliminar más de los que existen
                            $maximoProducto = array_count_values($_SESSION['cesta']);
                            //Hacemos consulta ala base de datos para que nos muestre los productos
                            $resultado = $conexion->query('SELECT * FROM producto WHERE cod=\'' . $valor . '\'');
                            $datos = $resultado->fetch_array();
                            //y guardamos el precio total de las unidades
                            $precioTotalUnidades = $datos['PVP'] * $maximoProducto[$valor]

                    ?>
                            <tr>
                                <!--Imprimimos los valores, donde en eliminar creamos $_POST ELIMINAR en array donde le insertamos
                                el código del producto como indice del array y le añadimos el máximo de productos que se pueden elimnar-->
                                <td><?php echo $datos['nombre_corto']; ?></td>
                                <td><?php echo $datos['PVP']; ?>€</td>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                                    <td><?php echo $maximoProducto[$valor] ?></td>
                                    <td><?php echo $precioTotalUnidades ?>€</td>
                                    <td id="sub"><input type="submit" value="Eliminar de cesta" name="eliminar[<?php echo $datos['cod'] ?>]"><input type="number" name="cantidadBorrado" min="1" max="<?php echo $maximoProducto[$valor] ?>"></td>
                                </form>
                            </tr>
                    <?php
                        }
                    } ?> <tr>
                        <!--Calculamos el precio total del carrito-->
                        <td COLSPAN="5">Total de la cesta= <?php echo calcularPrecioCarrito($conexion) ?>€</td>
                    </tr>
                </table><br>
                <!--Creamos un formulario para cerrar se sesión-->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="submit" value="Cerra sesión" name="cerrarSesion">
                </form>

        </body>

        </html>
        <!--Cerramos la conexion-->
<?php $conexion->close();
            }
        }
    } ?>