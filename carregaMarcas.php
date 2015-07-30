<?php

session_start();

require_once("Controller/Marcas.php");

$action = $_GET['action'];
$index = $_SESSION['indexMarcas'];

$marcas = ListaMarcas();
$m = count($marcas);

if ($m == 0)
{
	echo "<br><br>No hay categoría agregada";
	return;
}

$newIndex = 0;
if ($action == "volta" && $action > 0)
{		
	$newIndex = $index - 5;
}
else if ($action == "avanca")
{
	$newIndex = $index + 5;
	if ($newIndex >= $m)
		$newIndex = $index;
}
$_SESSION['indexMarcas'] = $newIndex;



$n = $newIndex + 5;
$c = 0;

$retval = "";
for ($i = $newIndex; $i < $n && $i < $m; $i++)
{
	$retval .=
	"<a href=\"Controller/Direciona.php?id=".$marcas[$i]['id']."&nome=marcas\" class=\"marca-box\">
		<img class=\"box-marcas\" width=\"107\" height=\"114\" src=\"".$_SESSION['marcasImagePrefix'] . $marcas[$i]['imagem']."\">
	</a>";
	
	$c++;
} 

echo $retval;

?>