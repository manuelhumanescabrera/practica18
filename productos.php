<?php
    session_start();
	require('conexion.php');
	//comprobamos que el rol de usuario sea administrador
	if (isset($_SESSION['id'])) {
            if(isset($_POST['submit'])){
                $id_producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $pvp = $_POST['precio'];
                $nombre_corto = $_POST['nombre_corto'];
                
                $producto['id'] = $id_producto;
                $producto['cantidad'] = $cantidad;
                $producto['importe_total'] = $cantidad * $pvp;
                $producto['nombre'] = $nombre_corto;
                
                $_SESSION['carrito'][$id_producto] = $producto;
                
                echo "id $id_producto cantidad: $cantidad pvp: $pvp nombre: $nombre_corto";
            }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<title>Panel de control</title>
</head>
<body>
<div class="container">
    <div class="row">
        <h3>Listado de productos</h3>
        <div class="jumbotron">
            <?php 
                if(isset($_SESSION['carrito'])){
                    for($i = 0; $i < count($_SESSION['carrito']); $i++){
                        var_dump($_SESSION['carrito']);
                    }
                }
                else{
                    echo "<p>El carrito está vacío.</p>";
                }
            ?>
        </div>
    </div>       
    <div class="row">
        <form method="post" action="" >
            <div class="form-group">
                <label>Filtro por familia:</label>
                <select class="form-control" name="familia">
                    <option value="-1">Todas las familias</option>
                    <?php
                        $sql_familias="SELECT cod,nombre FROM familia ORDER BY nombre";
                        $resultado_familias = $mysqli->query($sql_familias) or die("Fallo al cargar las familias");
                        while($fila = $resultado_familias->fetch_assoc()){
                            if(isset($_POST['filtro']) && $_POST['familia'] != -1){
                                if($fila['cod'] == $_POST['familia']){ 
                                    echo "<option value='".$fila['cod']."' selected>".$fila['nombre']."</option>";
                                }
                                else{
                                    echo "<option value='".$fila['cod']."'>".$fila['nombre']."</option>";
                                }
                            }
                            else{
                                echo "<option value='".$fila['cod']."'>".$fila['nombre']."</option>";
                            }
                        }

                    ?>
                </select>
            </div>
            <button type="submit" name="filtro" class="btn btn-info form-control">Filtrar</button>
        </form><br>
    </div>
    <div class="row">        
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>                      
                      <th>Familia</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Añadir</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $condicion = "WHERE 1";
                if(isset($_POST['filtro']) && $_POST['familia'] != -1){
                    $familia = $_POST['familia'];
                    $condicion = "WHERE familia='$familia'";
                }
                $consulta = "SELECT cod,nombre_corto,descripcion,pvp,familia FROM producto $condicion ORDER BY familia";

                    if ($resultado = $mysqli->query($consulta)) {

                                //recogemos e imprimimos el array de objetos
                                        while ($fila = $resultado->fetch_assoc()) {
                                            echo '<form method="post" action="productos.php">';
                                            echo '<tr>';                                            
                                            echo '<td>'. $fila['familia'] . '</td>';
                                            echo '<td>'. $fila['nombre_corto'] . '</td>';
                                            echo '<td>'. $fila['descripcion'] . '</td>';
                                            echo '<td>'. $fila['pvp'] . '€</td>';
                                            echo '<td><input type="text" name="cantidad" class="form-control input-sm" value="1"></td>';
                                            echo '<td><input type="hidden" name="producto" value='.$fila['cod'].'>'
                                                    . '<input type="hidden" name="precio" value='.$fila['pvp'].'>'
                                                    . '<input type="hidden" name="nombre_corto" value='.$fila['nombre_corto'].'>'
                                                    . '<input type="submit" class="btn btn-success btn-sm" name="submit" value="Añadir"/>';
                                            echo '</tr>';
                                            echo '</form>';
                                        }

                                // liberar el conjunto de resultados 
                                    $resultado->close();
                    }
                ?>
                </tbody>
            </table>
            <button type="submit" class="form-control btn btn-success" name="comprar">Comprar</button>        
    </div>
</div> <!-- /container -->
<a href="logout.php">Cerrar sesión</a>
<?php
	}
	else{
?>
<p>no tienes permiso para estar aqui</p>
<?php
	}
?>
</body>
</html>
