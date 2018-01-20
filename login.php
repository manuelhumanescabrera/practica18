<?php
	session_start();
	require('conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<title>Login</title>
</head>
<body>
	<?php
		
		
		if (isset($_POST['username'])){
                    $username = stripslashes($_POST['username']);
		    //escapamos los caracteres especiales del string
			$username = $mysqli->real_escape_string($username); 
			$password = stripslashes($_POST['password']);
			$password = $mysqli->real_escape_string($password);
			//Sacamos el hash de la base de datos para compararlo
			$consulta_hash = "SELECT clave FROM usuarios WHERE usuario='$username'";
			
			
			if($objeto_hash = $mysqli->query($consulta_hash)){
				$hash = $objeto_hash->fetch_assoc(); //aqui es donde almacenamos el hash del usuario
			}
			else{
				echo $mysqli->error;
			}
			
			
			//Comprobamos si la contraseña introducida es correcta
			if(password_verify($password, $hash['clave'])){
		        $consulta = "SELECT * FROM usuarios WHERE usuario='$username' and clave='".$hash['clave']."'";
		        //Aqui se comprueba si la consulta se ha hecho correctamente o nos lanza el error
		        if ($resultado = $mysqli->query($consulta)){
					$row = $resultado->fetch_assoc();
					
				}
				else{
					echo $mysqli->error;
				}
			
				// Comprobamos que solo haya un resultado para nuestra consulta.			
			    if($resultado->num_rows==1){
					
                                //asignamos valores a la variables de session
                                $_SESSION['username'] = $username;
                                $_SESSION['id'] = $row['id_usuario'];
                                // Redireccion a la pagina de inicio
                                header("Location: productos.php");
		         	
		         	
		    	}
		    	
			}
			else{
					echo "<div class='form'>
					<h3>Usuario/contraseña incorrectos.</h3>
					<br/>Para iniciar sesión <a href='login.php'>haz click aquí.</a></div>";
			}
			
			

		}
	?>
<div class="container">
	<div class="row">
		<h1>Iniciar sesión</h1>
	</div>
	<div class="row">
		<form action="" method="post" name="login">
		<div class="form-group">
			<label for="username">Usuario</label>
			<input type="text" class="form-control" name="username" placeholder="Usuario" required />
		</div>
		<div class="form-group">	
			<label for="password">Contraseña</label>
			<input type="password" class="form-control" name="password" placeholder="Contraseña" required />
		</div>
			<button name="submit" class="btn btn-default" type="submit" value="Login">Entrar</button>
		</form>
		<p>¿Aún no te has registrado? <a href='index.php'>Registrate aquí</a></p>
	</div>
</div>
</body>
</html>
