<?php

require_once("Marcas.php");
require_once("Categorias.php");
require_once("Arquivos.php");

$text = $_POST['searchText'];

$searchText = "%".$text."%";
$resultados = array();

// Buscar nas marcas
$marcas = GetMarcasByName($searchText);
$resultados["marcas"] = $marcas;

// Buscar nos albuns
$albuns = GetAlbunsByName($searchText);
$resultados["albuns"] = $albuns;

// Buscar nos arquivos
$arquivos = GetArquivosByName($searchText);
$resultados["arquivos"] = $arquivos;

$_SESSION['search_result'] = $resultados;
$_SESSION['search_text'] = $text;

header("location: ../busca.php");

?>