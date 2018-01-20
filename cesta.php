<?php
    session_start();
	require('conexion.php');
	//comprobamos que el rol de usuario sea administrador
	if (isset($_SESSION['id'])) {
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
        <h3>Cesta de la compra</h3>
    </div>           
    <div class="row">
        <form method="post" action="cesta.php">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Familia</th>
                      <th>Nombre</th>                      
                      <th>Precio</th>                      
                    </tr>
                </thead>
                <tbody>
                <?php                
                $productos = $_POST['productos'];
                $total_cesta = 0;
                $_SESSION['productos'] = $productos;
                for($i = 0; $i < count($productos); $i++){
                    $sql_producto = "SELECT * FROM producto WHERE cod='".$productos[$i]."'";
                    $resultado_prod = $mysqli->query($sql_producto) or die("Fallo al mostrar productos");
                    while($fila = $resultado_prod->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$fila['cod']."</td>";
                        echo "<td>".$fila['familia']."</td>";
                        echo "<td>".$fila['nombre_corto']."</td>";
                        echo "<td>".$fila['PVP']."€</td>";
                        echo "</tr>";
                        $total_cesta += $fila['PVP'];
                    }
                }
                ?>
                    <tr>
                        <td colspan="3">Total cesta:</td>
                        <td><?php echo $total_cesta; ?>€</td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="form-control btn btn-success" name="comprar">Pagar</button>
        </form>
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
