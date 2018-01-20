<?php 
    session_start();   
    if(isset($_SESSION['id'])){
       header('Location: productos.php');      
    }
      
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<title>Registration</title>
</head>
<body>
<?php 
require('conexion.php');
// Si el formulario ha sido enviado, inserta valores en la base de datos.
if (isset($_POST['username'])){
    //escapamos los caracteres especiales del string
	$username = stripslashes($_POST['username']);
	$username = $mysqli->real_escape_string($username); 
	$password = stripslashes($_POST['password']);
	$password = $mysqli->real_escape_string($password);
        $nombre = stripslashes($_POST['nombre']);
        $nombre = $mysqli->real_escape_string($nombre);
    //encriptamos la contraseña por seguridad
    $password = password_hash($password, PASSWORD_DEFAULT);
    //$rol = $_POST['rol'];
	//$trn_date = date("Y-m-d H:i:s"); //esto es para generar la fecha y hora de registro

        $consulta = "INSERT INTO usuarios(usuario, nombre, clave) VALUES ('$username', '$nombre', '$password')";
       //comprobamos si la inserccion se ha realizado con exito y mostramos un mensaje indicandolo
        if ($resultado = $mysqli->query($consulta)){
            echo "Usuario registrado con éxito. Para iniciar sesión <a href='login.php'>pincha aquí</a>";
            echo $rol;
        }
        else{
            echo $mysqli->error;
        }
        //cerramos la conexion con la bbdd
        $resultado->close();
        
    }else{
?>
<div class="container">
<div class="row">
    <h1>Registro de Usuarios</h1>
</div>
<div class="row">
    <form name="registration" action="" method="post">
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" name="username" class="form-control" placeholder="Usuario" required />
        </div>
        <div class="form-group">   
            <label for="nombre">Nombre y apellidos:</label>
            <input type="text" name="nombre" class="form-control" placeholder="Nombre y apellidos" required />
        </div>
        <div class="form-group">   
            <label for="password">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required />
        </div>
        <!--<div class="form-group">
            <label for="rol">Rol de usuario:</label>
            <select name="rol">
               <option value="administrador">Administrador</option>
               <option value="editor">Editor</option>
            </select>
        </div>-->
        
        <button type="submit" class="btn btn-default" name="submit" value="Register">Registrar</button>
    </form>
</div>
<p>¿Ya estás registrado? <a href='login.php'>Iniciar sesión</a></p>
</div>
<?php } ?>
</body>
</html>