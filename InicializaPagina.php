<?php
require_once ("Engine/UsuariosClass.php");

session_start();


if (!isset($_SESSION['logado']) || $_SESSION['logado'] == FALSE)
{
	header("location: index.php?error=Logue antes de navegar");
}

?>