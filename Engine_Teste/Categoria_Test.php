<?php

require_once ("../Engine/CategoriasClass.php");

$categorias = new Categorias();

echo "Teste ADICIONAR CATEGORIA<br>";
$res = $categorias->AdicionaCategoria("Imagens", "C:\Users\Jorge\Documents\Projetos\Biblioteca Virtual\Imagens_categorias\imagem.png");
if ($res == TRUE)
{
	echo "Categoria adicionada!";
}

echo "<br><br>";

echo "Teste CARREGA CATEGORIAS<br>";
$result = $categorias->CarregaCategorias();
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

echo "Teste REMOVE CATEGORIA<br>";
$res = $categorias->RemoveCategoria($result[$n - 1]["id"]);
if ($res == TRUE)
{
	echo "Categoria Removida!";
}

?>