<?php
/* Archivo para cerrar sesión */
	session_start();
	session_unset(); //aqui es donde vaciamos las variables de sesión.
	header("Location: index.php");
?>