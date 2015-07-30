<?php
require_once(dirname(dirname(__FILE__))."/Engine/UsuariosClass.php");
require_once(dirname(dirname(__FILE__))."/Engine/GruposClass.php");

if (isset($_POST['addSubmitted']))
{
	CadastraGrupo();
}
else if (isset($_POST['altSubmitted']))
{
	if (isset($_POST['marcaID']))
	{
		AlteraGrupo($_POST['marcaID']);	
	}
	else
	{
		header("location: ../grupos.php?status=error");
	}
}
else if (isset($_POST['selData']))
{
	$id = $_POST['selData'];

	RemoveGrupo($id);
}

// Pega todos os grupos do banco de dados
function GetGrupos()
{
	$grupos = new Grupos();
	
	$result = $grupos->ListaGrupos();
	
	return $result;
}

// Pega apenas o grupo com ID especificado
function GetGrupo($id)
{
	$grupo = new Grupos();
	
	$result = $grupo->GetGruposByID($id);
	
	return $result;
}

// Remove o grupo de ID especificado do banco de dados
function RemoveGrupo($id)
{
	$grupos = new Grupos();
	
	$result = $grupos->DeleteGrupo($id);
	
	if ($result == TRUE)
	{
		header("location: ../grupos.php?status=success");	
	}
	else
	{
		header("location: ../grupos.php?status=error");		
	}
	
	return;
}

// Cadastra um novo grupo
function CadastraGrupo()
{
	 $erro = Array();
    
    foreach ($_POST as $chv => $vlr) 
    {
        if($vlr == "" && substr($chv,0,3) == "GRP") 
        {
            $erro[] = "O campo " . substr($chv,4) . " não foi informado";
        }
    }
	
	$n = count($erro);
	if ($n > 0)
	{
		header("location: ../grupos.php?status=error");
		return;
	}
	
	$grupos = new Grupos();
	
	$_nome = $_POST['GRP_NOME'];
	$_cats = $_POST['GRP_CATS'];
	
	// Cria a lista de categorias, separadas por virgula
	$categorias = "";
	$n = count($_cats);
	for ($i = 0; $i < $n; $i++)
	{
		$categorias .= $_cats[$i] . ",";
	}
	$categorias = substr_replace($categorias, "", -1);
	
	// Adiciona o grupo e redireciona
	
	$result = $grupos->AdicionaGrupo($_nome, $categorias);
		
	if ($result == TRUE)
	{
		header("location: ../grupos.php?status=success");	
	}
	else
	{
		header("location: ../grupos.php?status=error");		
	}
	
	return;
}

// Altera o grupo com o ID especificado
function AlteraGrupo($id)
{
	$grupos = new Grupos();
	
	$nome = null;
	$novasCategorias = null;
	
	if (isset($_POST['GRP_NOME']))
	{
		$nome = $_POST['GRP_NOME'];
	}
	if (isset($_POST['GRP_CATS']))
	{
		$_cats = $_POST['GRP_CATS'];	
		// Cria a lista de categorias, separadas por virgula
		$categorias = "";
		$n = count($_cats);
		for ($i = 0; $i < $n; $i++)
		{
			$categorias .= $_cats[$i] . ",";
		}
		$novasCategorias = substr_replace($categorias, "", -1);
	}
	
	$result = $grupos->AlteraGrupo($id, $nome, $novasCategorias);
	
	if ($result == TRUE)
	{
		header("location: ../grupos.php?status=success");	
	}
	else
	{
		header("location: ../grupos.php?status=error");		
	}
	
	return;
}

function GetCategoriasAutorizadas($user)
{
	if ($user->isAdmin)
	{
		$auth = array();
		
		$categorias = GetCategorias();
		$n = count($categorias);
		for ($i = 0; $i < $n; $i++)
		{
			array_push($auth, $categorias[$i]['id']);	
		}
		
		return $auth;
	}
	
	$grupo = new Grupos();
	
	$grupoID = $user->Grupo;
	
	$catAcessos = $grupo->GetCategoriasAcesso($grupoID);
	
	return $catAcessos;
}



?>