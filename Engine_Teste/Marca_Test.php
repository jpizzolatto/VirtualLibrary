<?php

require_once ("../Engine/MarcasClass.php");

$marcas = new Marcas();

echo "Teste ADICIONAR MARCA<br>";
$res = $marcas->AdicionaMarca("Vaxxxtek", "C:\Users\Jorge\Documents\Projetos\Biblioteca Virtual\Imagens_marcas\VAXXITEK logo.JPG");
if ($res == TRUE)
{
	echo "Marca adicionada!";
}

echo "<br><br>";

echo "Teste CARREGA MARCAS<br>";
$result = $marcas->CarregaMarcas();
if (isset($result))
{
	$n = count($result);
	
	for ($i=0; $i < $n; $i++) 
	{
		echo "ID: " . $result[$i]["id"] . "<br>";
		echo "NOME: " . $result[$i]["nome"] . "<br>"; 
	}
}

echo "<br><br>";

echo "Teste REMOVE MARCA<br>";
$res = $marcas->RemoveMarca($result[$n - 1]["id"]);
if ($res == TRUE)
{
	echo "Marca Removido!";
}

?>