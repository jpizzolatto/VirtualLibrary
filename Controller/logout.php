<?php

require_once (dirname(dirname(__FILE__))."/Engine/DatabaseClass.php");

session_start();

$_SESSION['logado'] = null;
$_SESSION['usuario'] = null;

session_unset();
session_destroy();

header ('location:../index.php');

?>