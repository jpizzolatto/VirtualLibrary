<?php

require_once ("DatabaseClass.php");
require_once ("CategoriasClass.php");
require_once ("MarcasClass.php");

Class Pastas
{
	public function __construct()
	{
		$bd = Database::singleton("localhost", "root", "", "biblioteca");
	}
	
	public function AdicionaPasta($_nome, $_categoria, $_marca)
	{
		$bd = Database::singleton();
		
		$values = array("nome" => $_nome, "categoria" => $_categoria, "marca" => $_marca);
		$result = $bd->Insert("pastas",  $values);
		
		return $result;
	}
	
	public function RemovePasta($_id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $_id);
		$result = $bd->Delete("pastas",  $where, null);
		
		return $result;
	}
	
	public function AlteraPasta($_id, $_nome)
	{
		$bd = Database::singleton();
		
		$values = array();
		if (isset($_nome))
		{
			$values["nome"] = $_nome;
		}
		
		$where = array("id" => $_id);
		$result = $bd->Update("pastas", $values, $where, null);
		
		return $result;
	}
	
	public function GetAlbumsFromCategoria($_marca, $_categoria)
	{
		$bd = Database::singleton();
		
		$where = array("marca" => $_marca, "categoria" => $_categoria);
		$union = array("AND");
		$result = $bd->Select("pastas", null, $where, $union);
		
		return $result;
	}
	
	public function GetAlbumsFromMarca($_marca)
	{
		$bd = Database::singleton();
		
		$where = array("marca" => $_marca);
		$result = $bd->Select("pastas", null, $where, null);
		
		return $result;
	}
	
	public function GetAlbumByID($_id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $_id);
		$result = $bd->Select("pastas", null, $where, null);
		
		return $result[0];
	}
	
	public function GetAlbunsByName($name)
	{
		$bd = Database::singleton();
		
		$where = array("nome" => $name);
		$result = $bd->Select("pastas", null, $where, null);
		
		return $result;
	}
}

?>