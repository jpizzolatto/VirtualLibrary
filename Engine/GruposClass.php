<?php
require_once("DatabaseClass.php");
require_once("UsuariosClass.php");

Class Grupos
{	
	public function __construct()
	{
		$bd = Database::singleton("localhost", "root", "", "biblioteca");
	}
	
	// Retornar as categorias que o grupo tem acesso
	public function GetCategoriasAcesso($id)
	{
		$bd = Database::singleton();
		
		$where_cond = array("id" => $id);
		$rows = $bd->Select("grupos", NULL, $where_cond, NULL);
		
		$row = reset($rows);
		$listaCategorias = explode (",", $row['categorias']);
		
		return $listaCategorias;
	}
	
	public function ListaGrupos()
	{
		$bd = Database::singleton();
		
		$rows = $bd->Select("grupos", NULL, NULL, NULL);
		
		return $rows;
	}
	
	// Verifica se um Usuario pode acessar a categoria
	public function VerificaAcesso(Usuarios $user, $categoria)
	{
		if ($user->Grupo->nome != $this->nome)
		{
			return FALSE;
		}
		
		$exist = in_array($categoria, $this->listaCategorias);
		
		return $exist;
	}
	
	// Adiciona um novo grupo de usuarios
	public function AdicionaGrupo($_nome, $categorias)
	{
		$bd = Database::singleton();
		
		$values = array("nome" => $_nome, "categorias" => $categorias);
		$result = $bd->Insert("grupos",  $values);
				
		return $result;
	}
	
	// Altera a lista de categorias de acesso de um grupo
	public function AlteraGrupo($id, $nome, $novasCategorias)
	{
		$bd = Database::singleton();
	
		$values = array();
		if (isset($nome))
		{
			$values["nome"] = $nome;	
		}
		if (isset($novasCategorias))
		{
			$values["categorias"] = $novasCategorias;
		}
		
		$where_clauses = array("id" => $id);
		
		$result = $bd->Update("grupos", $values, $where_clauses, NULL);
		
		return $result;
	}
	
	// Deleta um grupo, dado um Nome do grupo
	public function DeleteGrupo($_id)
	{
		$bd = Database::singleton();
		
		$where_clauses = array("id" => $_id);
		$result = $bd->Delete("grupos", $where_clauses, NULL);
				
		return $result;
	}
	
		
	public function GetGruposByID($id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $id);
		$result = $bd->Select("grupos", null, $where, null);
		
		return $result[0];
	}
}


?>