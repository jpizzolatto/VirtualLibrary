<?php

require_once ("DatabaseClass.php");


Class Categorias
{
	public function __construct()
	{
		$bd = Database::singleton("localhost", "root", "", "biblioteca");
		$_SESSION['categoriasImagePrefix'] = "Imagens_categorias/";
	}
	
	public function AdicionaCategoria($_nome, $_imagem)
	{
		$bd = Database::singleton();
		
		$values = array("nome" => $_nome, "imagem" => $_imagem);
		$result = $bd->Insert("categorias",  $values);
		
		return $result;
	}
	
	public function RemoveCategoria($_id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $_id);
		$result = $bd->Delete("categorias",  $where, null);
		
		return $result;
	}
	
	public function CarregaCategorias ()
	{
		$bd = Database::singleton();
		
		$result = $bd->Select("categorias", null, null, null);
		
		return $result;
	}
	
	public function GetCategoriasByName($name)
	{
		$bd = Database::singleton();
		
		$where = array("nome" => $name);
		$result = $bd->Select("categorias", null, $where, null);
		
		return $result;
	}
	
	public function GetCategoriaByID($id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $id);
		$result = $bd->Select("categorias", null, $where, null);
		
		return $result[0];
	}
	
	public function AlteraCategoria($id, $nome, $imagem)
	{
		$bd = Database::singleton();
	
		$values = array();
		if (isset($nome))
		{
			$values["nome"] = $nome;	
		}
		if (isset($imagem))
		{
			$values["imagem"] = $imagem;
		}
		
		$where_clauses = array("id" => $id);
		
		$result = $bd->Update("categorias", $values, $where_clauses, NULL);
		
		return $result;
	}
}

?>