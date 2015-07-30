<?php

require_once("Marcas.php");
require_once("Categorias.php");
require_once("Arquivos.php");

if (isset($_GET["nome"]))
{
	$nome = $_GET['nome'];
}

if (isset($_GET["id"]))
{
	$id = $_GET['id'];
}

switch ($nome) 
{
	case 'marcas':
		selecionaMarca($id);	
			
		if (!isset($_SESSION['marca']))
		{
			echo "<script>alert('Marca não encontrada!');</script>";
			header("location: home.php");
		}
		
		header("location: ../marcas.php");
		break;
	
	case 'pasta':
		// Reseta index de albuns
		if (isset($_SESSION['albumIndex']))
		{
			$_SESSION['albumIndex'] = 0;
		}
		selecionaCategoria($id);
		
		if (!isset($_SESSION['categoria']))
		{
			echo "<script>alert('Categoria não encontrada!');</script>";
			header("location: home.php");
		}
		
		header("location: ../albuns.php");
		break;
	case 'arquivos':
		$arquivo = GetArquivo($id);
		$album = GetAlbum($arquivo['album']);
		$_SESSION['currAlbum'] = $album;
		
		selecionaCategoria($album['categoria']);
		selecionaMarca($album['marca']);
		
		header("location: ../arquivo-escolhido.php?id=".$id);
		
		break;
	case 'albuns':
		$album = GetAlbum($id);
		
		selecionaCategoria($album['categoria']);
		selecionaMarca($album['marca']);
		
		header("location: ../arquivos.php?album=".$id);
		
		break;
	default:
		
		break;
}


?>