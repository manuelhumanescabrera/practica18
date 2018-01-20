<?php
/* Archivo de conexion a la bbdd
Es aquí donde debemos modificar los datos en función de la base de datos donde queramos conectarnos.
Los datos usuario, contraseña y base_de_datos debes sustituirlos por los de conexion a tu bbdd.*/
	$mysqli = new mysqli("localhost", "root", "", "dwes");

/* comprobar la conexión */
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}
?>
