<?php

require_once ("DatabaseClass.php");
require_once ("CategoriasClass.php");

Class Marcas
{
	public function __construct()
	{
		$bd = Database::singleton("localhost", "root", "", "biblioteca");
		$_SESSION['marcasImagePrefix'] = "Imagens_marcas/";
	}
	
	public function AdicionaMarca($_nome, $_imagem)
	{
		$bd = Database::singleton();
		
		$values = array("nome" => $_nome, "imagem" => $_imagem);
		$result = $bd->Insert("marcas",  $values);
		
		return $result;
	}
	
	public function RemoveMarca($_id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $_id);
		$result = $bd->Delete("marcas",  $where, null);
		
		return $result;
	}
	
	public function CarregaMarcas()
	{
		$bd = Database::singleton();
		
		$result = $bd->Select("marcas", null, null, null);
		
		return $result;
	}
	
	public function GetMarcaByID($id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $id);
		$result = $bd->Select("marcas", null, $where, null);
		
		return $result[0];
	}
	
	public function GetMarcasByName($name)
	{
		$bd = Database::singleton();
		
		$where = array("nome" => $name);
		$result = $bd->Select("marcas", null, $where, null);
		
		return $result;
	}
	
	public function AlteraMarca($id, $nome, $imagem)
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
		
		$result = $bd->Update("marcas", $values, $where_clauses, NULL);
		
		return $result;
	}
}

?>